<?php


namespace AlwaysBlank\Schemer;


use AlwaysBlank\Brief\Brief;

class Node
{
    protected $itemscope;
    protected $itemprop;
    protected $itemtype;
    protected $selfclosing;
    protected $content;
    protected $tag;

    protected function __construct(Brief $Args)
    {
        $this->setItemscope($Args);
        $this->setItemprop($Args);
        $this->setItemtype($Args);
        $this->setSelfClosing($Args);
        $this->setContent($Args);
        $this->setTag($Args);
    }

    public function __toString()
    {
        return $this->render();
    }

    public static function add(Brief $Args)
    {
        return new static($Args);
    }

    public function render()
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

    protected function setItemscope(Brief $Args)
    {
        $this->itemscope = false !== $Args->itemscope ? true : false;
    }

    protected function setSelfClosing(Brief $Args)
    {
        $this->selfclosing = false !== $Args->selfclosing ? true : false;
    }

    protected function setItemprop(Brief $Args)
    {
        $this->itemprop = is_string($Args->itemprop) ? $Args->itemprop : false;
    }

    protected function setItemtype(Brief $Args)
    {
        $this->itemtype = is_string($Args->itemtype) ? $Args->itemtype : false;
    }

    protected function setContent(Brief $Args)
    {
        $this->content = is_string($Args->content) ? $Args->content : false;
    }

    protected function setTag(Brief $Args)
    {
        $this->tag = $Args->tag ?: 'span';
    }
}