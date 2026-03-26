<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Interest extends Model
{
    public function register(int $programmeId, string $studentName, string $email): bool
    {
        $withdrawToken = bin2hex(random_bytes(16));

        $stmt = $this->db()->prepare("INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email, IsActive, WithdrawToken)
                                      VALUES (:programme_id, :student_name, :email, 1, :withdraw_token)
                                      ON DUPLICATE KEY UPDATE
                                          StudentName = VALUES(StudentName),
                                          IsActive = 1,
                                          WithdrawToken = VALUES(WithdrawToken),
                                          WithdrawnAt = NULL");

        return $stmt->execute([
            'programme_id' => $programmeId,
            'student_name' => $studentName,
            'email' => $email,
            'withdraw_token' => $withdrawToken,
        ]);
    }

    public function findByEmail(string $email): array
    {
        $stmt = $this->db()->prepare("SELECT i.InterestID, i.StudentName, i.Email, i.RegisteredAt, i.IsActive,
                                             p.ProgrammeName
                                      FROM InterestedStudents i
                                      INNER JOIN Programmes p ON p.ProgrammeID = i.ProgrammeID
                                      WHERE i.Email = :email
                                      ORDER BY i.RegisteredAt DESC");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchAll();
    }

    public function withdraw(int $interestId): void
    {
        $stmt = $this->db()->prepare('UPDATE InterestedStudents SET IsActive = 0, WithdrawnAt = NOW() WHERE InterestID = :id');
        $stmt->execute(['id' => $interestId]);
    }

    public function all(): array
    {
        return $this->db()->query("SELECT i.InterestID, p.ProgrammeName, i.StudentName, i.Email, i.RegisteredAt, i.IsActive
                                   FROM InterestedStudents i
                                   INNER JOIN Programmes p ON p.ProgrammeID = i.ProgrammeID
                                   ORDER BY p.ProgrammeName, i.StudentName")->fetchAll();
    }

    public function deactivate(int $interestId): void
    {
        $this->withdraw($interestId);
    }
}
