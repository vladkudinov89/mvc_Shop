<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">
                            <?php foreach ($categories as $categoryItem): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/category/<?php echo $categoryItem['id']; ?>">
                                                <?php echo $categoryItem['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">оформления заказа</h2>


                        <?php if ($result): ?>

                            <p>Заказ оформлен. Мы Вам перезвоним.</p>


                        <?php elseif (!$result && isset($errors1) ): ?>

                            <?php if (isset($errors1) && is_array($errors1)): ?>

                                <?php foreach ($errors1 as $error): ?>
                                    <p> - <?php echo $error; ?></p>
                                <?php endforeach; ?>

                            <?php endif; ?>
                            <a class="btn btn-default checkout" href="/"><i class="fa fa-shopping-cart"></i> Вернуться к
                                покупкам</a>

                        <?php else: ?>

                            <p>Выбрано товаров: <?php echo $totalQuantity; ?>, на сумму: <?php echo $totalPrice; ?>,
                                грн.</p><br/>

                            <div class="col-sm-4">
                                <?php if (isset($errors) && is_array($errors)): ?>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li> - <?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>

                                <div class="login-form">
                                    <form action="#" method="post">

                                        <p>Ваше имя</p>
                                        <input type="text" name="userName" placeholder=""
                                               value="<?php echo $userName; ?>"/>

                                        <p>Номер телефона</p>
                                        <input type="tel" name="userPhone" placeholder=""
                                               value="<?php echo $userPhone; ?>"/>

<!--                                        <p>Email</p>-->
<!--                                        <input type="email" name="userEmail" placeholder=""-->
<!--                                               value="--><?php //echo $userEmail; ?><!--"/>-->

                                        <p>Комментарий к заказу</p>
                                        <input type="text" name="userComment" placeholder="Сообщение"
                                               value="<?php echo $userComment; ?>"/>

                                        <br/>
                                        <br/>
                                        <input type="submit" name="submit" class="btn btn-default" value="Оформить"/>
                                    </form>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>