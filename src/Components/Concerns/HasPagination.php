<?php

namespace Hasnayeen\Xumina\Components\Concerns;

trait HasPagination
{
    protected int|string $perPage = 15;

    protected bool $paginated = false;

    protected array $pageSizeOptions = [10, 25, 50, 'all'];

    public function perPage(int|string $perPage): static
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function paginated(bool|array $paginated): static
    {
        if (is_array(paginated)) {
            $this->perPageOptions = $paginated;
        } else {
            $this->paginated = $paginated;
        }

        return $this;
    }
}
