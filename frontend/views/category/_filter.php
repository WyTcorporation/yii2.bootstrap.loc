<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 17.09.2021
 * Time: 09:08
 * User: WyTcorporation, WyTcorp, WyTco
 */

/* @var $characteristics */
/* @var $isPjax */

?>

<?php for ($x = 0; $x <= count($characteristics); $x++) : ?>
<?php if(isset($characteristics[$x]['name'])) : ?>
    <div class="form-group">
        <button class="btn btn-primary"
                type="button"> <?= $characteristics[$x]['name']; ?></button>
        <div class="col-sm-12 collapse in scroll-pane jspScrollable" id="pfi_14"
             style="overflow: auto; padding: 0px; width: 246px;">
            <?php
            $height = 160;

            if (isset($characteristics[$x]['options']) && !empty($characteristics[$x]['options'])) {
                $calc = 31 * count($characteristics[$x]['options']);
                $height = $calc < 160 ? $calc : 160;
            }
            ?>
            <div class="jspContainer"
                 style="width: 246px; height: <?= $height ?>px;">
                <div class="jspPane">
                    <?php if (isset($characteristics[$x]['options']) && !empty($characteristics[$x]['options'])) : ?>
                        <?php $options = $characteristics[$x]['options']; ?>
                        <?php if (isset($options) && !empty($options)) : ?>
                            <?php for ($y = 0; $y <= count($options); $y++) : ?>
                                <?php if (isset($options[$y]) && !empty($options[$y])) : ?>
                                    <?php if (isset($characteristics[$x]['radio']) && !empty($characteristics[$x]['radio'])) : ?>
                                        <div class="radio  <?php
                                        if($options[$y]['active']) {
                                            echo  'checked';
                                        } elseif ($options[$y]['disabled']) {
                                            echo 'disabled';
                                        }  ?>">
                                            <input
                                                    type="radio"
                                                    id="delete_<?= $options[$y]['id'] ?>"
                                                    name="radio[]"
                                                    value="<?= $options[$y]['id'] ?>"
                                                <?php
                                                if($options[$y]['active']) {
                                                   echo  'checked';
                                                } elseif ($options[$y]['disabled']) {
                                                    echo 'disabled';
                                                }  ?>
                                            >
                                            <label
                                                    class="inner"
                                                    for="delete_<?= $options[$y]['id'] ?>"></label>
                                            <label
                                                    class="outer"
                                                    for="delete_<?= $options[$y]['id'] ?>"><?= $options[$y]['name'] ?></label>
                                        </div>
                                    <?php else: ?>
                                        <div class="checkbox  <?php
                                        if($options[$y]['active']) {
                                            echo  'checked';
                                        } elseif ($options[$y]['disabled']) {
                                            echo 'disabled';
                                        }  ?>">
                                            <input type="checkbox"
                                                   id="delete_<?= $options[$y]['id'] ?>"
                                                   name="checkbox[]"
                                                   value="<?= $options[$y]['id'] ?>"
                                                <?php
                                                if($options[$y]['active']) {
                                                    echo  'checked';
                                                } elseif ($options[$y]['disabled']) {
                                                    echo 'disabled';
                                                }  ?>
                                            >
                                            <label
                                                    class="inner"
                                                    for="delete_<?= $options[$y]['id'] ?>"></label>
                                            <label
                                                    class="outer"
                                                    for="delete_<?= $options[$y]['id'] ?>"><?= $options[$y]['name'] ?></label>
                                        </div>

                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>

                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endfor; ?>
