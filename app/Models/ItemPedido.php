<?php

namespace App\Models;

use App\Core\Model;

class ItemPedido extends Model {
    protected ?int $id = null;
    protected int $pedidoId;
    protected int $servicoId;
    protected int $quantidade = 1;
    protected float $precoUnitario;
    protected float $subtotal;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getPedidoId(): int {
        return $this->pedidoId;
    }

    public function setPedidoId(int $pedidoId): self {
        $this->pedidoId = $pedidoId;
        return $this;
    }

    public function getServicoId(): int {
        return $this->servicoId;
    }

    public function setServicoId(int $servicoId): self {
        $this->servicoId = $servicoId;
        return $this;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function getPrecoUnitario(): float {
        return $this->precoUnitario;
    }

    public function setPrecoUnitario(float $precoUnitario): self {
        $this->precoUnitario = $precoUnitario;
        return $this;
    }

    public function getSubtotal(): float {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self {
        $this->subtotal = $subtotal;
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
