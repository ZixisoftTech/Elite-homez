<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Testimonial extends Model {
    protected string $table = 'testimonials';

    public function getPublished(): array {
        $sql = "SELECT * FROM testimonials WHERE status = 1 ORDER BY sort_order ASC, id ASC";
        return $this->fetchAll($sql);
    }
}
