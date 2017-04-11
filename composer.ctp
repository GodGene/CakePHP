<?php
$this->Breadcrumbs->add(__d('admin', 'Home'), ['controller' => 'default', 'action' => 'index']);
$this->Breadcrumbs->add(__d('admin', 'Tools'));
?>
<style>
    .console-form .console-output{
        margin: 0px;
        padding: 5px;
        width: 100%;
        height: 500px;
        border: none!important;
        border-radius: 0!important;
        overflow-y: scroll;
        overflow-x: hidden;
        background: #000;
        color: #fff;
        line-height: 12px;
    }
    .console-form .console-line {
        position: relative;
    }
    .console-form .form-group .console-hashtag {
        position: absolute;
        top: 7px;
        left: 5px;
        z-index: 99;
        color: #fff;
    }
    .console-form .form-group input {
        padding-left: 92px;
        border: none;
        background: #000;
        color: #fff;
        border-radius: 0;
    }
    .console-form .form-group button {
        display: block;
    }
</style>
<?= $this->Form->create(false, [
    'id' => 'console-form',
    'class' => 'console-form'
]) ?>
    <div class="form-group">
        <pre class="console-output well"></pre>
        <div class="console-line">
            <span class="console-hashtag">> composer</span>
            <?= $this->form->control('command', ['class' => 'form-control console-input'])?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php
$this->Html->scriptBlock("$(document).ready(function() {
    var form = $('#console-form');
    var input = $('.console-input');
    var output = $('.console-output');
    
    form.on('submit', function (e) {
        e.preventDefault();
        var formData = form.serialize();
        
        if (input.val().length > 0) {
            output.append('> composer ' + input.val() + '\\n');
            input.val('');
            output.append('> Please wait ...\\n');
            output.animate({ scrollTop: output[0].scrollHeight }, 1000);
        } else {
            output.append('> Please enter command ' + '\\n');
            output.animate({ scrollTop: output[0].scrollHeight }, 1000);       
        }    
        $.ajax({
			type: 'post',
			url: '".$this->Url->build(['action' => 'ajax', 'act' => 'composer'])."',
			data: formData,
			success: function(data) {
			    if (data.length > 0) {
			        output.append('> ' + data + '\\n');
			        output.animate({ scrollTop: output[0].scrollHeight }, 1000);
			    }    
            }
        });       
        
        
    });
   
})", ['block' => 'jsblock']);
?>
