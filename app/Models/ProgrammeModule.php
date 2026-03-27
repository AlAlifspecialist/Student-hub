<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ProgrammeModule extends Model
{
    public function allMappings(): array
    {
        return $this->db()->query("SELECT pm.ProgrammeModuleID, p.ProgrammeName, m.ModuleName, pm.Year
                                   FROM ProgrammeModules pm
                                   INNER JOIN Programmes p ON p.ProgrammeID = pm.ProgrammeID
                                   INNER JOIN Modules m ON m.ModuleID = pm.ModuleID
                                   ORDER BY p.ProgrammeName, pm.Year, m.ModuleName")->fetchAll();
    }

    public function assign(int $programmeId, int $moduleId, int $year): void
    {
        $stmt = $this->db()->prepare('INSERT INTO ProgrammeModules (ProgrammeID, ModuleID, Year) VALUES (:programme_id, :module_id, :year)');
        $stmt->execute([
            'programme_id' => $programmeId,
            'module_id' => $moduleId,
            'year' => $year,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db()->prepare('DELETE FROM ProgrammeModules WHERE ProgrammeModuleID = :id');
        $stmt->execute(['id' => $id]);
    }
}
