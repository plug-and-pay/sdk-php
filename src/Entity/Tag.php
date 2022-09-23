<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Tag
{
   private string $name;

   public function name(): string
   {
       return $this->name;
   }

   public function setName(string $name): self
   {
       $this->name = $name;
       return $this;
   }
}
