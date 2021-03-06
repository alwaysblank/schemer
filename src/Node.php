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

    public const INLINE = [
        'a',
        'abbr',
        'audio',
        'b',
        'bdo',
        'button',
        'canvas',
        'cite',
        'code',
        'command',
        'data',
        'datalist',
        'dfn',
        'em',
        'embed',
        'i',
        'iframe',
        'img',
        'input',
        'kbd',
        'keygen',
        'label',
        'mark',
        'math',
        'meter',
        'noscript',
        'object',
        'output',
        'picture',
        'progress',
        'q',
        'ruby',
        'samp',
        'script',
        'select',
        'small',
        'span',
        'strong',
        'sub',
        'sup',
        'svg',
        'textarea',
        'time',
        'var',
        'video',
    ];

    /**
     * This inserts some kind of zero-width space after inline elements, so that
     * browsers will allow them to move to the next line. <wbr> would be a
     * better solution, but unfortunately IE doesn't support it.
     */
    public const SPACER = '&#8203;';

    protected $itemscope;
    protected $itemprop;
    protected $itemtype;
    protected $content;
    protected $attributes;
    protected $tag;
    protected $selfclosing;
    protected $inline;
    protected $empty;

    protected function __construct(array $args)
    {
        if (empty($args)) {
            // This is essentially the "false" state
            $this->empty = true;
        } else {
            // Make this a Brief so handling it is easier.
            $Args = new Brief($args, $this->getBriefSettings());

            $this->setItemscope($Args);
            $this->setItemprop($Args);
            $this->setItemtype($Args);
            $this->setContent($Args);
            $this->setTag($Args);
            $this->setSelfClosing($Args);
            $this->setInline($Args);
            $this->setAttributes($Args);
        }
    }

    protected function getBriefSettings()
    {
        return [
            'aliases' => [
                'itemscope'  => ['scope', 'iscope'],
                'itemprop'   => ['prop', 'iprop'],
                'itemtype'   => ['type', 'itype'],
                'attributes' => ['attr', 'attrs'],
            ]
        ];
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function empty(): bool
    {
        return true === $this->empty;
    }

    public function notEmpty(): bool
    {
        return ! $this->empty();
    }

    public static function add(array $args): self
    {
        return new static($args);
    }

    public function render(): string
    {
        if ($this->empty()) {
            return '';
        }

        $attributes = [];

        if ($this->itemscope) {
            $attributes[] = 'itemscope';
        }

        if ($this->itemprop) {
            $attributes[] = 'itemprop="' . $this->itemprop . '"';
        }

        if ($this->itemtype) {
            $attributes[] = 'itemtype="' . $this->itemtype . '"';
        }

        if (is_array($this->attributes)) {
            $attributes[] = array_reduce($this->attributes, function ($carry, $item) {
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
            $tag = "<{$this->tag} $rendered_attributes />";
        } else {
            $tag = "<{$this->tag} $rendered_attributes>{$this->content}</{$this->tag}>";
        }

        if ($this->inline) {
            $tag .= '<span class="spc">' . $this::SPACER . '</span>';
        }

        return $tag;
    }

    protected function setItemscope(Brief $Args): void
    {
        $this->itemscope = false !== $Args->itemscope ? true : false;
    }

    protected function setSelfClosing(Brief $Args): void
    {
        $this->selfclosing = in_array($this->tag, $this::SELFCLOSING);
    }

    protected function setInline(Brief $Args): void
    {
        $this->inline = in_array($this->tag, $this::INLINE);
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
