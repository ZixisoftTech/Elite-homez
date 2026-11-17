<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class CarouselSlide extends Model {
    protected string $table = 'carousel_slides';

    public function getActive(): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function allOrdered(): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY sort_order ASC, id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function toggleStatus(int $id): bool {
        $slide = $this->find($id);
        if (!$slide) {
            return false;
        }
        $newStatus = !empty($slide['is_active']) ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
