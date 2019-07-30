<?php


namespace AlwaysBlank\Schemer;


use AlwaysBlank\Brief\Brief;

class Node
{
    public const SELFCLOSING = [
        'img',
        'br',
        'hr',
        'source',
        'input',
        'meta',
        'embed',
    ];

    protected $itemscope;
    protected $itemprop;
    protected $itemtype;
    protected $content;
    protected $attributes;
    protected $tag;
    protected $selfclosing;

    protected function __construct(array $args)
    {
        // Make this a Brief so handling it is easier.
        $Args = new Brief($args);

        $this->setItemscope($Args);
        $this->setItemprop($Args);
        $this->setItemtype($Args);
        $this->setSelfClosing($Args);
        $this->setContent($Args);
        $this->setTag($Args);
        $this->setAttributes($Args);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public static function add(array $args): self
    {
        return new static($args);
    }

    public function render(): string
    {
        $attributes = [];

        if ($this->itemscope) {
            $attributes[] = 'itemscope';
        }

        if ($this->itemprop) {
            $attributes[] = 'itemprop="' . $this->itemprop . '"';
        }

        if ($this->itemtype) {
            $attributes[] = 'itemprop="' . $this->itemtype . '"';
        }

        if (is_array($this->attributes)) {
            $attributes[] = array_reduce($this->attributes, function($carry, $item) {
                $attribute = true === $item[1]
                    ? $item[0]
                    : "{$item[0]}=\"{$item[1]}\"";
                return false === $carry ? $attribute : "$carry $attribute";
            }, false);
        }

        if ($this->selfclosing && $this->content) {
            $attributes[] = 'content="' . $this->content . '"';
        }

        $rendered_attributes = join(' ', $attributes);

        if ($this->selfclosing) {
            return "<{$this->tag} $rendered_attributes />";
        } else {
            return "<{$this->tag} $rendered_attributes>{$this->content}</{$this->tag}>";
        }
    }

    protected function setItemscope(Brief $Args): void
    {
        $this->itemscope = false !== $Args->itemscope ? true : false;
    }

    protected function setSelfClosing(Brief $Args): void
    {
        $this->selfclosing = in_array($Args->tag, $this::SELFCLOSING);
    }

    protected function setItemprop(Brief $Args): void
    {
        $this->itemprop = is_string($Args->itemprop) ? $Args->itemprop : false;
    }

    protected function setItemtype(Brief $Args): void
    {
        $this->itemtype = is_string($Args->itemtype) ? $Args->itemtype : false;
    }

    protected function setContent(Brief $Args): void
    {
        $this->content = is_string($Args->content) ? $Args->content : false;
    }

    protected function setTag(Brief $Args): void
    {
        $this->tag = $Args->tag ?: 'span';
    }

    protected function setAttributes(Brief $Args)
    {
        if ($Args->attributes && is_array($Args->attributes)) {
            $collected_attributes = [];
            foreach ($Args->attributes as $key => $value) {
                $collected_attributes[] = [$key, $value];
            }
            $this->attributes = $collected_attributes;
        }
    }
}