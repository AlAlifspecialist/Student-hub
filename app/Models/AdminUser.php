<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class AdminUser extends Model
{
    public function findActiveByUsername(string $username): array|false
    {
        $stmt = $this->db()->prepare('SELECT AdminID, Username, PasswordHash, FullName, Role FROM AdminUsers WHERE Username = :username AND IsActive = 1 LIMIT 1');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }
}
