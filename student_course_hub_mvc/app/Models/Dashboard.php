<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Dashboard extends Model
{
    public function stats(): array
    {
        return [
            'programmeCount' => (int) $this->db()->query('SELECT COUNT(*) FROM Programmes')->fetchColumn(),
            'publishedCount' => (int) $this->db()->query('SELECT COUNT(*) FROM Programmes WHERE IsPublished = 1')->fetchColumn(),
            'moduleCount' => (int) $this->db()->query('SELECT COUNT(*) FROM Modules')->fetchColumn(),
            'interestCount' => (int) $this->db()->query('SELECT COUNT(*) FROM InterestedStudents WHERE IsActive = 1')->fetchColumn(),
        ];
    }
}
