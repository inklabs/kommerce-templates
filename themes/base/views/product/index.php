<?php
/**
 * @var \inklabs\kommerce\EntityDTO\ProductDTO $product
 */

View::set_global('page_title', HTML::chars($product->name));

$ogMeta = [];
$ogMeta['og:type'] = 'product';
$ogMeta['og:url'] = $product->fullUrl;
$ogMeta['og:title'] = $product->name;
$ogMeta['og:image:secure_url'][] = Kohana::$config->load('environment')->get('base_url').substr($product->defaultImageUrl, 1);

foreach ($product->images as $image) {
    if ($image->path !== $product->defaultImage) {
        $ogMeta['og:image:secure_url'][] = Kohana::$config->load('environment')->get('base_url').substr($image->pathUrl, 1);
    }
}

if (! empty($product->combinedDescription)) {
    $ogMeta['og:description'] = nl2br(HTML::chars($product->combinedDescription));
}

View::set_global('ogMeta', $ogMeta);

HTML::add_assets([
    '/asset/kohana-kommerce/js/product_index.js',
]);
?>
<div class="container">
    <div class="row" id="product">
        <div class="col-md-9 col-sm-12">
            <div class="row">
                <div class="col-sm-5 text-center" id="product-image-container">
                    <img id="product-image" src="<?=$product->defaultImageUrl?>" />
                    <?php if ( ! empty($product->images)) { ?>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-lg-3 col-xs-4">
                                <a href="<?=$product->defaultImageUrl?>" class='product-image'>
                                    <img src="<?=$product->defaultImageUrl?>" style="width: 100px;" />
                                </a>
                            </div>
                            <?php foreach ($product->images as $image) { ?>
                                <?php if ($image->path !== $product->defaultImage) { ?>
                                    <div class="col-lg-3 col-xs-4">
                                        <a href="<?=$image->pathUrl?>" class='product-image'>
                                            <img src="<?=$image->pathUrl?>" style="width: 100px;" />
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($product->rating !== NULL) { ?>
                        <div class="divider"></div>

                        <div class="review-actions">
                            <?=View::factory('helper/rating_stars_static')->set([
                                'rating' => $product->rating,
                                'count' => TRUE,
                            ])?>
                            <?php if ( ! empty($reviews)) { ?>
                                <a href="#ratings">Read all reviews</a> |
                            <?php } ?>
                            <a href="<?=URL::site('review/add')?>">Write a review</a>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-sm-7">
                    <h1><?=HTML::chars($product->name)?></h1>

                    <?php if ($product->isInventoryRequired) { ?>
                        <div class="availability" style="margin-top: 20px; margin-bottom: 5px">Availability:
                            <?php if ($product->quantity > 0) { ?>
                                <span class="in-stock">In stock</span>
                            <?php } else { ?>
                                <span class="out-of-stock">Out of stock</span>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?=View::factory('helper/display_price', ['price' => $product->price])?>
                    <br />

                    <?php if ( ! empty($product->productQuantityDiscounts)) { ?>
                        <div class="divider"></div>
                        <div class="discount-prices">
                            <?php foreach (array_reverse($product->productQuantityDiscounts) as $discount) { ?>
                                Buy <?=$discount->quantity?> or more for

                                <?php if ($product->price->unitPrice < $discount->price->unitPrice) { ?>
                                    <span class="price-strike"><?=Kommerce::display_price($discount->price->unitPrice)?></span>
                                    <?=Kommerce::display_price($product->price->unitPrice)?>
                                <?php } else { ?>
                                    <?=Kommerce::display_price($discount->price->unitPrice)?>
                                <?php } ?>

                                each
                                <br />
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ( ! empty($group_products)) { ?>

                        <?=Form::open($product->url(), [
                            'id' => 'group_products',
                            'method' => 'POST',
                            'class' => 'form-inline',
                        ])?>
                        <?=Form::csrf()?>

                        <?php foreach ($product_attribute_grid as $attribute_id => $values) { ?>
                            <?php $attribute = Arr::get($attributes, $attribute_id); ?>

                            <?php
                            $current_attribute_value = NULL;
                            $a_values = [];
                            foreach ($values as $attribute_value_id => $value) {
                                $attribute_value = Arr::get($attribute_values, $attribute_value_id);

                                $a_values[$attribute_value->id] = $attribute_value->name;

                                if (in_array($product->id, $value)) {
                                    $current_attribute_value = $attribute_value->id;
                                }
                            }
                            ?>

                            <div class="row">
                                <div class="form-group">
                                    <label for="attribute_<?=$attribute->id?>" class="control-label"><?=HTML::chars($attribute->name)?></label>
                                    <?=Form::select('attribute_value[' . $attribute->id . ']', $a_values, $current_attribute_value, [
                                        'id' => 'attribute_' . $attribute->id,
                                        'class' => 'form-control',
                                    ])?>
                                </div>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-edit"></i> Modify
                        </button>

                        <?=Form::close()?>
                    <?php } ?>

                    <?php if ($product->isInStock) { ?>
                        <?=Form::open('cart/add_item', [
                            'id' => 'cart_add_item',
                            'method' => 'POST',
                            'class' => 'form-inline',
                        ])?>
                        <?=Form::csrf()?>
                    <?php } ?>

                    <?php if (! empty($product->options) || ! empty($product->textOptions)) { ?>
                        <div class="divider"></div>
                        <div class="actions">
                            <?php foreach($product->options as $option) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="control-group">
                                            <?=View::factory('product/options')->set([
                                                'option' => $option
                                            ])?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php foreach($product->textOptions as $textOption) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="control-group">
                                            <?=View::factory('product/text_options')->set([
                                                'textOption' => $textOption
                                            ])?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($product->isInStock) { ?>
                        <div class="divider"></div>
                        <div class="actions">
                            <input type="hidden" name="id" value="<?=$product->id->getHex()?>" />
                            <button type="submit" class="btn btn-success pull-right">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <div class="input-group input-group-sm col-xs-4 col-sm-3">
                                <span class="input-group-addon"><label for="quantity">Qty:</label></span>
                                <input class="form-control quantity" type="text" id="quantity" name="quantity" value="1" />
                            </div>
                        </div>
                        <?=Form::close()?>
                    <?php } ?>

                    <?php if ( ! empty($product->description)) { ?>
                        <div class="divider"></div>
                        <dl>
                            <dt class="description-info">Description</dt>
                            <dd class="description-desc"><?=nl2br(HTML::chars($product->description))?></dd>
                        </dl>
                    <?php } ?>

                    <?php if ( ! empty($product->tags)) { ?>
                        <div class="divider"></div>
                        <?php $simple_tags = array(); ?>
                        <?php foreach ($product->tags as $tag) { ?>
                            <?php if (! $tag->isVisible) { continue; } ?>
                            <?php if (! empty($tag->description)) { ?>
                                <dl>
                                    <dt class="tag-info"><a href="<?=$tag->url?>">
                                            <?=HTML::chars($tag->name)?></a>
                                    </dt>
                                    <dd class="tag-desc"><?=nl2br(HTML::chars($tag->description))?></dd>
                                </dl>
                            <?php } else { ?>
                                <?php $simple_tags[] = '<a href="' . $tag->url . '">' .
                                    HTML::chars($tag->name) . '</a>'; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <?php if ( ! empty($simple_tags)) { ?>
                        <div id="more-tags">
                            Tags: <?=implode(' | ', $simple_tags)?>
                        </div>
                    <?php } ?>

                    <div class="divider"></div>

                    <div class="other-actions">
                        <div id="social-actions">
                            <?=HTML::anchor('https://www.facebook.com/sharer/sharer.php?u=' . $product->fullUrl,
                                '<i class="glyphicon glyphicon-share"></i> Share on Facebook</a>',
                                [
                                    'class' => 'btn btn-primary btn-xs facebook-share',
                                    'target' => '_blank',
                                ]
                            )?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ( ! empty($reviews)) { ?>
                <div class="col-sm-9" id="reviews">
                    <h2>Reviews</h2>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-3 col-sm-12">
            <?php if ( ! empty($relatedProducts)) { ?>
                <h2 class="text-center">You Might Also Like</h2>
                <?=View::factory('helper/product_grid_small')->set([
                    'products' => $relatedProducts,
                    'lg_slim' => TRUE,
                ])?>
            <?php } ?>
        </div>
    </div>
</div>
