<?php
/**
 * @var \inklabs\kommerce\EntityDTO\UserDTO $user
 * @var \inklabs\kommerce\EntityDTO\CartDTO $cart
 */
if ( ! isset($page_title)) {
    $page_title = SITE_NAME;
} else {
    $page_title .= ' | ' . SITE_NAME;
}

if ( ! isset($canonical_url)) {
    $canonical_url = URL::site(Request::current()->uri(), TRUE);
}

HTML::add_assets([
    'kommerce-main.css',
    'kommerce-main.js',
], TRUE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$page_title?></title>
    <?php if (Kommerce::is_prod()) { ?>
        <meta name="robots" content="all" />
        <meta name="GOOGLEBOT" content="index,follow" />
        <meta name="robots" content="index,follow" />
    <?php } ?>
    <?php
    if (isset($ogMeta)) {
        foreach ($ogMeta as $key => $meta) {
            if (is_array($meta)) {
                foreach ($meta as $metaItem) {
                    echo '<meta property="' . $key . '" content="' . $metaItem . '" />' . PHP_EOL;
                }
            } else {
                echo '<meta property="' . $key . '" content="' . $meta . '" />' . PHP_EOL;
            }
        }
    }
    ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="<?=@$page_description?>">
    <link rel="icon" href="/favicon.ico" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="canonical" href="<?=$canonical_url?>" />
    <?php
    if (isset(HTML::$assets['css']) AND is_array(HTML::$assets['css'])) {
        foreach (HTML::$assets['css'] as $css) {
            echo HTML::style($css) . "\n\t";
        }
    }

    if (isset(HTML::$assets['js']) AND is_array(HTML::$assets['js'])) {
        foreach (HTML::$assets['js'] as $js) {
            echo HTML::script($js) . "\n\t";
        }
    }

    if ( ! empty(HTML::$before_scripts)) {
        foreach (HTML::$before_scripts as $data) {
            echo '<script type="text/javascript">' . $data . '</script>' . "\n\t";
        }
    }
    if ( ! empty(HTML::$before_head)) {
        foreach (HTML::$before_head as $data) {
            echo $data . "\n\t";
        }
    }
    ?>
    <?=View::factory('helper/google_analytics')?>
</head>
<body>
<div id="header">
    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="glyphicon glyphicon-align-justify"></i></button>
                <a class="navbar-brand" href="<?=URL::site('')?>"><?=SITE_NAME?></a>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right text-center">
                    <?php if ($user !== null) { ?>
                        <li>
                            <a href="<?=URL::site('action/logout')?>">Sign Out</a>
                        </li>
                        <li class="divider-vertical hidden-xs"></li>
                        <li><?=HTML::anchor('user/account', 'Account')?></li>
                    <?php } else { ?>
                        <li>
                            <a href="<?=URL::site('login')?>">Sign In</a>
                        </li>
                    <?php } ?>

                    <li class="divider-vertical hidden-xs"></li>

                    <li>
                        <a href="<?=URL::site('cart')?>">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            Cart
                            <?php if ($cart !== null && $cart->totalQuantity > 0) { ?>
                                (<?=$cart->totalQuantity?>)
                            <?php } ?>
                        </a>
                    </li>
                </ul>

                <div class="col-sm-3 navbar-right">
                    <?=Form::open('search', [
                        'method' => 'GET',
                        'class' => 'navbar-form',
                        'role' => 'search',
                    ])?>
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="search" value="<?=@$search_query?>" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default search-button"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                    <?=Form::close()?>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

<div id="promo">
    <?=View::factory('helper/promo')?>
</div>

<?=View::factory('helper/messages')?>
<?=View::factory('helper/breadcrumbs')?>

<div id="body">
    <?=$content?>
</div>

<?=View::factory('helper/base_modal')?>

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?=HTML::anchor('conidtions', 'Conditions of Use')?>
                | <?=HTML::anchor('privacy', 'Privacy')?>
                <?=SITE_COPY?>
            </div>
        </div>
    </div>
    <?php if (Kommerce::isProfilingEnabled()) { ?>
        <?=View::factory('profiler')?>
    <?php } ?>
</div>
</body>
</html>
