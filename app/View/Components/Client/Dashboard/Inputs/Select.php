<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component {
    public array $normalizedOptions = [];

    public function __construct(
        public string $name,
        public string $label,
        public mixed  $options = [],
        public string $placeholder = '',
        public string $info = '',
        public string $default = '',
    )
    {
        $this->normalizedOptions = $this->normalizeOptions($options);
    }

    private function normalizeOptions(mixed $sourceOptions): array
    {
        $result = [];

        foreach ($sourceOptions as $key => $item) {
            $groupData = $this->detectGroup($item);

            if ($groupData) {
                $result[] = [
                    'is_group' => true,
                    'label' => $groupData['label'],
                    'options' => $groupData['items'],
                ];
                continue;
            }

            $result[] = [
                'is_group' => false,
                'value' => $this->resolveValue($item, $key),
                'label' => $this->resolveLabel($item, $key),
            ];
        }

        return $result;
    }

    private function detectGroup($item): ?array
    {
        $children = $item->children ?? null;

        if ($children && count($children) > 0) {
            return [
                'label' => $item->name ?? $item->label ?? 'Group',
                'items' => $this->formatSubItems($children)
            ];
        }

        $majors = $item->majors ?? null;

        if ($majors && count($majors) > 0) {
            return [
                'label' => $item->name ?? $item->label ?? 'Group',
                'items' => $this->formatSubItems($majors)
            ];
        }

        return null;
    }

    private function formatSubItems($items): array
    {
        $formatted = [];
        foreach ($items as $child) {
            $id = is_object($child) ? ($child->id ?? null) : ($child['id'] ?? null);
            $label = is_object($child)
                ? ($child->name ?? $child->label ?? null)
                : ($child['name'] ?? $child['label'] ?? null);

            if ($id === null || $label === null) {
                continue;
            }

            $formatted[] = [
                'value' => (string)$id,
                'label' => (string)$label,
            ];
        }

        return $formatted;
    }

    private function resolveValue($item, $key): string
    {
        if (is_object($item)) return (string)$item->id;
        return (string)$key;
    }

    private function resolveLabel($item, $key)
    {
        if (is_object($item)) return $item->name ?? $item->label;
        if (is_array($item)) return $item['label'] ?? $key;
        return $item;
    }

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.select');
    }
}
