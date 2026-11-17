<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class PropertyImage extends Model {
    protected string $table = 'property_images';

    public function getByProperty(int $propertyId): array {
        $sql = "SELECT * FROM property_images WHERE property_id = :pid ORDER BY is_featured DESC, sort_order ASC, id ASC";
        return $this->fetchAll($sql, ['pid' => $propertyId]);
    }

    public function add(int $propertyId, string $path, string $caption = '', int $sortOrder = 0, int $isFeatured = 0): int {
        return $this->create([
            'property_id' => $propertyId,
            'image_path' => $path,
            'caption' => $caption,
            'sort_order' => $sortOrder,
            'is_featured' => $isFeatured
        ]);
    }
}
