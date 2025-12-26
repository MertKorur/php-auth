<?php

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function userExists(string $username, string $email): bool
    {
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email
        ]);

        return $stmt->fetch() !== false;
    }

    public function createUser(string $username, string $email, string $passwordHash): void
    {
        $sql = "INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $passwordHash
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":email" => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":username" => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}