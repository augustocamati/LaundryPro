<?php

namespace App\Models;

use App\Core\Model;

class Usuario extends Model {
    protected ?int $id = null;
    protected int $perfilId;
    protected string $nome;
    protected string $email;
    protected string $senha;
    protected ?string $telefone = null;
    protected string $status = 'ativo';
    protected ?string $tokenRecuperacao = null;
    protected ?string $tokenExpiraEm = null;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }

    public function getPerfilId(): int { return $this->perfilId; }
    public function setPerfilId(int $perfilId): self { $this->perfilId = $perfilId; return $this; }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): self { $this->nome = $nome; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getSenha(): string { return $this->senha; }
    public function setSenha(string $senha): self { $this->senha = $senha; return $this; }

    public function getTelefone(): ?string { return $this->telefone; }
    public function setTelefone(?string $telefone): self { $this->telefone = $telefone; return $this; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }

    public function getTokenRecuperacao(): ?string { return $this->tokenRecuperacao; }
    public function setTokenRecuperacao(?string $token): self { $this->tokenRecuperacao = $token; return $this; }

    public function getTokenExpiraEm(): ?string { return $this->tokenExpiraEm; }
    public function setTokenExpiraEm(?string $expira): self { $this->tokenExpiraEm = $expira; return $this; }

    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function setCreatedAt(?string $createdAt): self { $this->createdAt = $createdAt; return $this; }

    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function setUpdatedAt(?string $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}
