<?php
$mv -> seo -> mergeParams('FAQ');

$total = $mv -> faq -> countRecords(['active' => 1, 'answer!=' => '']);
$mv -> faq -> runPaginator($total, 10);

$form = new Form('Faq');
$form -> useTokenCSRF();
$form -> addField(['Security code', 'char', 'captcha', [
    'captcha' => 'extra/captcha-simple?intro',
    'session_key' => 'captcha'
]]);

$form -> setRequiredFields(['name', 'question', 'captcha']) -> setCaption('name', 'Your name');

$form -> submit() -> validate();
	
if($form -> isValid())
{
    $record = $mv -> faq -> getEmptyRecord();
    $record -> date = I18n::getCurrentDate();
    $record -> setValues($form -> getAllValues(['name', 'question']));
    $record -> create();

    $mv -> reload('?done#form-area');
}

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>FAQ</h1>
		<section class="items-list faq">
			<?php echo $mv -> faq -> display(); ?>
		</section>
        <?php if($mv -> faq -> paginator -> hasPages()): ?>
            <div class="paginator">
                <span>Page:</span>
                <?php echo $mv -> faq -> paginator -> display($mv -> root_path.'faq'); ?>
            </div>
        <?php endif; ?>
        
        <h3 id="form-area">Ask question</h3>
        <?php
            if(Http::fromGet('done') !== null)
                echo "<div class=\"form-success\"><p>The form has been successfully completed.</p></div>\n";
            else
                echo $form -> displayErrors();
        ?>
        <form method="post" action="<?php echo $mv -> root_path; ?>faq#form-area">
            <?php
                echo $form -> display(['name', 'question', 'captcha']);
                echo $form -> displayTokenCSRF();
            ?>
            <button>Submit</button>
        </form>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>