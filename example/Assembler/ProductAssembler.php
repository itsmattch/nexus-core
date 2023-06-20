<?php

namespace Assembler;

use Itsmattch\Nexus\Assembler\Assembler;

// conceptual assembler
class ProductAssembler extends Assembler
{
    // a model that this assembler produces
    protected string $model = Product::class;

    /*
     * list of resources that must be requested in given order
     *
     * I've an idea of asynchronous assemblers, which will simply
     * get only the information that is currently available and
     * return whatever they find at a moment, but I need to consider
     * how to do it properly while keeping the library stateless.
     *
     * by the way, should resources be named or not? like pim => class etc.
     */
    protected array $resources = [
        PIM\ReadProduct::class,
        ERP\ReadProduct::class,
        WMS\ReadProduct::class,
    ];

    /*
     * either default key passed to assembler will be used, or a custom one from here
     *
     * following piece goes like this: the key of ERP\ReadProduct can be found
     * in PIM\ReadProduct in ['data']['sku']. The ERP\ReadProduct expects it to be
     * passed as "sku" parameter.
     *
     * without it, we would simply assume that both resources expect "id" param.
     */
    protected array $keys = [
        ERP\ReadProduct::class => [PIM\ReadProduct::class, 'data.sku', 'sku'],
    ];

    /*
     * a blueprint it uses
     *
     * how does blueprint receive information from resources? should it simulatenous, or
     * one after another calling the blueprint on the same model?
     *
     * imagine we have two identical keys with different values. how to handle such
     * concurrency?
     */
    protected string $blueprint = ProductBlueprint::class;
}