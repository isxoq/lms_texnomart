<?php

/* @var $this \soft\web\SView */

?>

<div class="col-sm-12">
    <div class="alert alert-warning background-warning">

        <div class="row">
            <div class=""
                 style="text-align: center; width: 90%">
                <h5>Hurmatli foydalanuvchi!</h5>
                <b>Sizdan telefon raqamingizni kiritishingiz so'raladi!</b>
                <br>
                <br>
                <p>
                    <b>
                        <a href="<?= to(['/profile/cabinet/enter-phone-number']) ?>" class="" >
                            <i class="fas fa-phone"></i>
                            Telefon raqamni kiritish uchun bu yerga bosing!
                        </a>
                    </b>
                </p>

            </div>

            <div class=""
                 style="display: grid; align-content: flex-start; justify-content: right; width: 9%" ; >
                <i data-dismiss="alert" aria-label="Close"
                   style="color: #fff; cursor: pointer"
                   class="fas fa-times"></i>
            </div>
        </div>


    </div>
</div>
