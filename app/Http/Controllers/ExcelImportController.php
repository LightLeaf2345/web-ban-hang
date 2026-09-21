<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('excel_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $directory = storage_path('app/temp');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $storedFileName = 'import.' . $extension;
        $fullPath = $directory . DIRECTORY_SEPARATOR . $storedFileName;
        $file->move($directory, $storedFileName);

        $rows = [];

        if (in_array($extension, ['xlsx', 'xls'])) {
            $rows = $this->readExcel($fullPath);
        } else {
            $rows = $this->readCsv($fullPath);
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $name = trim((string) $this->getRowValue($row, ['name', 'product_name', 'ten_san_pham']));
            $sku = trim((string) $this->getRowValue($row, ['sku', 'code', 'ma_sku']));
            $price = (float) $this->getRowValue($row, ['price', 'gia', 'gia_ban']);
            $quantity = (int) $this->getRowValue($row, ['quantity', 'stock', 'so_luong']);
            $categoryName = trim((string) $this->getRowValue($row, ['category', 'category_name', 'danh_muc'])) ?: 'Chung';
            $description = trim((string) $this->getRowValue($row, ['description', 'mieu_ta', 'mo_ta']));

            if ($name === '' || $sku === '') {
                $skipped++;
                continue;
            }

            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['description' => 'Imported from Excel', 'status' => 'active']
            );

            $existing = Product::where('sku', $sku)->first();
            if ($existing) {
                $existing->update([
                    'name' => $name,
                    'category_id' => $category->id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'status' => $quantity > 0 ? 'active' : 'inactive',
                    'description' => $description,
                ]);
                $updated++;
            } else {
                Product::create([
                    'name' => $name,
                    'sku' => $sku,
                    'category_id' => $category->id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'status' => $quantity > 0 ? 'active' : 'inactive',
                    'description' => $description,
                    'image' => '/images/default-product.png',
                ]);
                $imported++;
            }
        }

        File::delete($fullPath);

        return response()->json([
            'success' => true,
            'message' => "Đã nhập {$imported} sản phẩm mới, cập nhật {$updated} sản phẩm và bỏ qua {$skipped} dòng.",
            'imported' => $imported,
            'updated' => $updated,
            'skipped' => $skipped,
        ]);
    }

    public function downloadSample(): \Illuminate\Http\Response
    {
        $content = "\xEF\xBB\xBF" . "Tên sản phẩm,SKU,Giá,Số lượng,Danh mục,Miêu tả\nÁo thun basic,ATB-001,199000,12,Áo Nam,Áo thun nhập từ mẫu\nQuần jean casual,QJC-001,349000,8,Quần Nam,Quần jean nhập từ mẫu\n";

        return response($content, 200)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="mau-import-san-pham.csv"');
    }

    protected function getRowValue(array $row, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $row)) {
                return $row[$key];
            }

            $normalized = $this->normalizeHeaderKey($key);
            if (array_key_exists($normalized, $row)) {
                return $row[$normalized];
            }
        }

        return '';
    }

    protected function normalizeHeaderKey(string $value): string
    {
        $normalized = Str::ascii($value);
        $normalized = strtolower($normalized);
        $normalized = preg_replace('/[^a-z0-9]+/', '_', $normalized) ?? '';

        return trim($normalized, '_');
    }

    protected function readCsv(string $path): array
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $row = [];
                foreach ($header as $index => $key) {
                    $row[$this->normalizeHeaderKey($key)] = $data[$index] ?? '';
                }
                $rows[] = $row;
            }
            fclose($handle);
        }

        return $rows;
    }

    protected function readExcel(string $path): array
    {
        $reader = null;

        if (class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $sheet = $reader->getActiveSheet();
            $rows = [];
            $header = [];

            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                $cells = [];
                foreach ($row->getCellIterator() as $cell) {
                    $cells[] = $cell->getFormattedValue();
                }

                if ($rowIndex === 1) {
                    $header = array_map(function ($value) {
                        return $this->normalizeHeaderKey((string) $value);
                    }, $cells);
                    continue;
                }

                $entry = [];
                foreach ($header as $index => $key) {
                    $entry[$key] = $cells[$index] ?? '';
                }
                $rows[] = $entry;
            }

            return $rows;
        }

        return [];
    }
}
