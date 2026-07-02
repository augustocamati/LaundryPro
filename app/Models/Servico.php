<?php

namespace App\Models;

use App\Core\Model;

class Servico extends Model {
    protected ?int $id = null;
    protected int $categoriaId;
    protected string $nome;
    protected ?string $descricao = null;
    protected float $preco;
    protected int $prazoDias = 1;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getCategoriaId(): int {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): self {
        $this->categoriaId = $categoriaId;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getDescricao(): ?string {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self {
        $this->descricao = $descricao;
        return $this;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function setPreco(float $preco): self {
        $this->preco = $preco;
        return $this;
    }

    public function getPrazoDias(): int {
        return $this->prazoDias;
    }

    public function setPrazoDias(int $prazoDias): self {
        $this->prazoDias = $prazoDias;
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
