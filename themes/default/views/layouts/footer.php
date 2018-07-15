    </div> <!-- /container -->

    <div id="footer">
        <div class="container">
            <div class="col-lg-4">
                Copyright &copy; <?=Yii::t('user', 'siteurl');?>, <?php echo date('Y') ?><br />
                <small>
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/wm.png', '', array('border'=>'0','title'=>Yii::t('user','WM Attestat')));?>
                    <!-- begin WebMoney Transfer : attestation label -->
                    <noindex><a href="https://passport.webmoney.ru/asp/certview.asp?wmid=136932805910" target="_blank"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/wm_v.png', '', array('border'=>'0','title'=>Yii::t('user','WM Attestat')));?></a></noindex>
                    <!-- end WebMoney Transfer : attestation label -->
                </small>
                <script type="text/javascript" src="https://seal.thawte.com/getthawteseal?host_name=gifm.ru&amp;size=M&amp;lang=en"></script>
                <div>
                    <a href="/upload/oferta.pdf" target="_blank">Договор-оферта</a>
                    <!--
                    <?=Yii::t('user', 'Generate time');?>: <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?>s. <?=Yii::t('user', 'Memory used');?>: <?=round(memory_get_peak_usage()/(1024*1024),2)."Mb"?><br />
                    -->
                </div>
            </div>
            <div class="col-lg-8">
                <div class="wegetpay"><?php echo Yii::t('user','Payment systems'); ?></div>
                <ul class="pay_methods_list">
                    <li class="item_1"><a href="/" target="_blank"><?php echo Yii::t('user','WebMoney'); ?></a></li>
                    <li class="item_2"><a href="/" target="_blank"><?php echo Yii::t('user','Yandex.Money'); ?></a></li>
                    <li class="item_3"><a href="/" target="_blank"><?php echo Yii::t('user','Qiwi'); ?></a></li>
                    <li class="item_4"><a href="/" target="_blank"><?php echo Yii::t('user','PayPal'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter23338147 = new Ya.Metrika({id:23338147, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/23338147" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>