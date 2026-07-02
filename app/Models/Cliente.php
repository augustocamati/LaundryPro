<?php

namespace App\Models;

use App\Core\Model;

class Cliente extends Model {
    protected ?int $id = null;
    protected string $nome;
    protected ?string $email = null;
    protected string $telefone;
    protected ?string $bi = null;
    protected ?string $endereco = null;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): self {
        $this->telefone = $telefone;
        return $this;
    }

    public function getBi(): ?string {
        return $this->bi;
    }

    public function setBi(?string $bi): self {
        $this->bi = $bi;
        return $this;
    }

    public function getEndereco(): ?string {
        return $this->endereco;
    }

    public function setEndereco(?string $endereco): self {
        $this->endereco = $endereco;
        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
