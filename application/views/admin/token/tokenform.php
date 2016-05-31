<?php
/**
* Add token entry
*/
?>


<div class=' <?php if( !isset($ajax) || $ajax = false ):?> side-body <?php echo getSideBodyClass(false); ?> <?php endif;?>' >
    <?php
        if (!isset($ajax) || $ajax = false)
            $this->renderPartial('/admin/survey/breadcrumb', array('oSurvey'=>$oSurvey, 'token'=>true, 'active'=>gT("Survey participant entry")));
    ?>

    <?php if (!isset($ajax) || $ajax = false):?>
        <h3>
            <?php
            if ($subaction == "edit")
            {
                eT("Edit survey participant");
                foreach ($tokendata as $Key => $Value)
                {
                    $$Key = $Value;
                }
            }
            else
            {
                eT("Add survey participant");
                $tokenid = "";
            }
            ?>
        </h3>
    <?php else:?>
        <?php
            foreach ($tokendata as $Key => $Value)
            {
                $$Key = $Value;
            }
            ?>
    <?php endif;?>


    <div class="row">
        <div class="col-lg-12 content-right">
            <?php echo CHtml::form(array("admin/tokens/sa/{$subaction}/surveyid/{$surveyid}/tokenid/{$tokenid}"), 'post', array('id'=>'edittoken', 'class'=>'form-horizontal')); ?>

            <!-- Tabs -->
            <?php if( count($attrfieldnames) > 0 ):?>
                <ul class="nav nav-tabs" id="edit-survey-text-element-language-selection">

                    <!-- Common  -->
                    <li role="presentation" class="active">
                        <a data-toggle="tab" href="#general" aria-expanded="true">
                            <?php eT('General'); ?>
                        </a>
                        </li>

                        <!-- Custom attibutes -->
                        <li role="presentation" class="">
                            <a data-toggle="tab" href="#custom" aria-expanded="false">
                                <?php eT('custom attributes'); ?>
                            </a>
                        </li>
                    </ul>
            <?php endif; ?>

            <!-- Tabs content-->
            <div class="tab-content">
                <!-- General -->
                <div id="general" class="tab-pane fade in  active ">

                    <!-- ID,Completed  -->
                    <div class="form-group">
                        <!-- ID  -->
                        <label class="col-sm-2 control-label">ID:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static">
                                <?php
                                    if ($subaction == "edit")
                                        echo $tokenid;
                                    else
                                        eT("Auto");
                                ?>
                            </p>
                        </div>

                        <!-- Completed -->
                        <label class="col-sm-2 control-label"  for='completed'><?php eT("Completed?"); ?></label>
                        <div class="col-sm-3">
                            <input class='form-control' type='text' size='20' id='completed' name='completed' value="<?php if (isset($completed)){echo $completed;}else{echo "N";}?>" />
                        </div>
                    </div>

                    <!-- First name, Last name -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for='firstname'><?php eT("First name"); ?>:</label>
                        <div class="col-sm-3">
                            <input class='form-control' type='text' size='30' id='firstname' name='firstname' value="<?php if (isset($firstname)){echo $firstname;} ?>" />
                        </div>
                        <label class="col-sm-2 control-label"  for='lastname'><?php eT("Last name"); ?>:</label>
                        <div class="col-sm-3">
                            <input class='form-control' type='text' size='30'  id='lastname' name='lastname' value="<?php if (isset($lastname)){echo $lastname;} ?>" />
                        </div>

                    </div>


                    <!-- Token, language -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label"  for='token'><?php eT("Token"); ?>:</label>
                        <div class="col-sm-3">
                            <input class='form-control' type='text' size='20' name='token' id='token' value="<?php if (isset($token)){echo $token;} ?>" />
                            <?php if ($subaction == "addnew"): ?>
                                <span id="helpBlock" class="help-block"><?php eT("You can leave this blank, and automatically generate tokens using 'Generate Tokens'"); ?></span>
                                <?php endif; ?>
                        </div>

                        <label class="col-sm-2 control-label"  for='language'><?php eT("Language"); ?>:</label>
                        <div class="col-sm-2">
                            <?php if (isset($language)){echo languageDropdownClean($surveyid, $language);}else{echo languageDropdownClean($surveyid, Survey::model()->findByPk($surveyid)->language);}?>
                            </div>
                    </div>



                    <!-- Email, Email Status  -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label"  for='email'><?php eT("Email"); ?>:</label>
                        <div class="col-sm-3">
                            <input class='form-control' type='email' multiple='multiple' maxlength='320' size='50' id='email' name='email' value="<?php if (isset($email)){echo $email;} ?>" />
                        </div>

                        <!-- Email Status -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"  for='emailstatus'><?php eT("Email Status"); ?>:</label>
                            <div class="col-sm-3">
                                <input class='form-control' type='text' maxlength='320' size='50' id='emailstatus' name='emailstatus' placeholder='OK' value="<?php if (isset($emailstatus)){echo $emailstatus;}else{echo "OK";}?>" />
                            </div>
                        </div>
                    </div>



                    <!-- Invitation sent, Reminder sent -->
                    <div class="form-group">

                        <!-- Invitation sent -->
                        <label class="col-sm-2 control-label"  for='sent'><?php eT("Invitation sent?"); ?></label>
                        <div class="col-sm-3" id="sent-yes-no-date-container">
                            <?php
                                $bSwitchValue       = (isset($sent) && $sent!='N')?"1":"0";
                                $bRemindSwitchValue = (isset($remindersent) && $remindersent!='N')?"1":"0";
                            ?>

                            <?php
                                $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
                                    'name' => "sent-switch",
                                    'id'=>"sent-switch",
                                    'htmlOptions'=>array('class'=>"YesNoDateSwitch"),
                                    'value' => $bSwitchValue,
                                    'onLabel'=>gT('Yes'),
                                    'offLabel' => gT('No')));
                            ?>

                            <div id="sent-date-container" class="date-container" <?php if(!$bSwitchValue):?>style="display: none;"<?php endif;?>>
                                <?php
                                Yii::app()->getController()->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                                    'name' => "sent-date",
                                    'id'   => "sent-date",
                                    'htmlOptions'=>array('class'=>"YesNoDatePicker"),
                                    'value' => isset($validuntil) ? $validuntil : '',
                                    'pluginOptions' => array(
                                        'format' => $dateformatdetails['jsdate'] . " HH:mm",
                                        'allowInputToggle' =>true,
                                        'showClear' => true,
                                        'tooltips' => array(
                                            'clear'=> gT('Clear selection'),
                                            'prevMonth'=> gT('Previous month'),
                                            'nextMonth'=> gT('Next month'),
                                            'selectYear'=> gT('Select year'),
                                            'prevYear'=> gT('Previous year'),
                                            'nextYear'=> gT('Next year'),
                                            'selectDecade'=> gT('Select decade'),
                                            'prevDecade'=> gT('Previous decade'),
                                            'nextDecade'=> gT('Next decade'),
                                            'prevCentury'=> gT('Previous century'),
                                            'nextCentury'=> gT('Next century'),
                                            'selectTime'=> gT('Select time')
                                        ),
                                        'locale' => convertLStoDateTimePickerLocale(Yii::app()->session['adminlang'])
                                        )
                                    ));
                                    ?>
                            </div>
                            <input class='form-control hidden YesNoDateHidden' type='text' size='20' id='sent' name='sent' value="<?php if (isset($sent)){echo $sent;}else{echo "N";}?>" />
                        </div>

                        <!-- Reminder sent -->
                        <label class="col-sm-2 control-label"  for='remindersent'><?php eT("Reminder sent?"); ?></label>
                        <div class="col-sm-3" id="remind-yes-no-date-container">
                            <?php
                                $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
                                    'name' => "remind-switch",
                                    'id'=>"remind-switch",
                                    'htmlOptions'=>array('class'=>"YesNoDateSwitch"),
                                    'value' => $bRemindSwitchValue,
                                    'onLabel'=>gT('Yes'),
                                    'offLabel' => gT('No')));
                            ?>

                            <div id="remind-date-container" class="date-container" <?php if(!$bRemindSwitchValue):?>style="display: none;"<?php endif;?>>
                            <?php
                            Yii::app()->getController()->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                                'name' => "remind-date",
                                'id'=>"remind-date",
                                'htmlOptions'=>array('class'=>"YesNoDatePicker"),
                                'value' => isset($validuntil) ? $validuntil : '',
                                'pluginOptions' => array(
                                    'format' => $dateformatdetails['jsdate'] . " HH:mm",
                                    'allowInputToggle' =>true,
                                    'showClear' => true,
                                    'tooltips' => array(
                                        'clear'=> gT('Clear selection'),
                                        'prevMonth'=> gT('Previous month'),
                                        'nextMonth'=> gT('Next month'),
                                        'selectYear'=> gT('Select year'),
                                        'prevYear'=> gT('Previous year'),
                                        'nextYear'=> gT('Next year'),
                                        'selectDecade'=> gT('Select decade'),
                                        'prevDecade'=> gT('Previous decade'),
                                        'nextDecade'=> gT('Next decade'),
                                        'prevCentury'=> gT('Previous century'),
                                        'nextCentury'=> gT('Next century'),
                                        'selectTime'=> gT('Select time')

                                    ),
                                    'locale' => convertLStoDateTimePickerLocale(Yii::app()->session['adminlang'])
                                )
                            ));
                            ?>
                        </div>
                            <input class='form-control hidden YesNoDateHidden' type='text' size='20' id='remindersent' name='remindersent' value="<?php if (isset($remindersent)){echo $remindersent;}else{echo "N";}?>" />
                        </div>
                    </div>


                    <!-- Reminder count, Uses left -->
                    <div class="form-group">
                        <!-- Reminder count -->
                        <?php if ($subaction == "edit"): ?>
                            <label class="col-sm-2 control-label"  for='remindercount'><?php eT("Reminder count:"); ?></label>
                            <div class="col-sm-3">
                                <input class='form-control' type='number' size='6' id='remindercount' name='remindercount' value="<?php echo $remindercount; ?>" />
                            </div>
                        <?php endif; ?>

                        <!-- Uses left -->
                        <label class="col-sm-2 control-label"  for='usesleft'><?php eT("Uses left:"); ?></label>
                        <div class="col-sm-3">
                            <input class='form-control' type='number' size='20' id='usesleft' name='usesleft' value="<?php if (isset($usesleft)){echo $usesleft;}else{echo "1";}?>" />
                        </div>
                    </div>


                    <!-- Valid from to  -->
                    <div class="form-group">

                        <!-- From -->
                        <label class="col-sm-2 control-label"  for='validfrom'><?php eT("Valid from"); ?>:</label>
                        <div class="col-sm-3 has-feedback">
                            <?php Yii::app()->getController()->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                                'name' => "validfrom",
                                'value' => isset($validfrom) ? $validfrom : '',
                                'pluginOptions' => array(
                                'format' => $dateformatdetails['jsdate'] . " HH:mm",
                                'allowInputToggle' =>true,
                                'showClear' => true,
                                'tooltips' => array(
                                    'clear'=> gT('Clear selection'),
                                    'prevMonth'=> gT('Previous month'),
                                    'nextMonth'=> gT('Next month'),
                                    'selectYear'=> gT('Select year'),
                                    'prevYear'=> gT('Previous year'),
                                    'nextYear'=> gT('Next year'),
                                    'selectDecade'=> gT('Select decade'),
                                    'prevDecade'=> gT('Previous decade'),
                                    'nextDecade'=> gT('Next decade'),
                                    'prevCentury'=> gT('Previous century'),
                                    'nextCentury'=> gT('Next century'),
                                    'selectTime'=> gT('Select time')
                                    ),
                                'locale' => convertLStoDateTimePickerLocale(Yii::app()->session['adminlang'])
                                )));
                            ?>

                            <span class='help-block'><?php echo sprintf(gT('Format: %s'), $dateformatdetails['dateformat'] . ' ' . gT('hh:mm')); ?></span>
                        </div>

                        <!-- To -->
                        <label class="col-sm-2 control-label"  for='validuntil'><?php eT('Until:'); ?></label>
                            <div class="col-sm-3 has-feedback">
                                <?php
                                    Yii::app()->getController()->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                                        'name' => "validuntil",
                                        'value' => isset($validuntil) ? $validuntil : '',
                                        'pluginOptions' => array(
                                        'format' => $dateformatdetails['jsdate'] . " HH:mm",
                                        'allowInputToggle' =>true,
                                        'showClear' => true,
                                        'tooltips' => array(
                                            'clear'=> gT('Clear selection'),
                                            'prevMonth'=> gT('Previous month'),
                                            'nextMonth'=> gT('Next month'),
                                            'selectYear'=> gT('Select year'),
                                            'prevYear'=> gT('Previous year'),
                                            'nextYear'=> gT('Next year'),
                                            'selectDecade'=> gT('Select decade'),
                                            'prevDecade'=> gT('Previous decade'),
                                            'nextDecade'=> gT('Next decade'),
                                            'prevCentury'=> gT('Previous century'),
                                            'nextCentury'=> gT('Next century'),
                                            'selectTime'=> gT('Select time')
                                        ),
                                        'locale' => convertLStoDateTimePickerLocale(Yii::app()->session['adminlang'])
                                    )));
                                ?>

                                <span class='help-block'><?php echo sprintf(gT('Format: %s'), $dateformatdetails['dateformat'] . ' ' . gT('hh:mm')); ?></span>
                            </div>
                    </div>
                </div>

                <!-- Custom attibutes -->
                <div id="custom" class="tab-pane fade in">
                    <!-- Attributes -->
                    <?php foreach ($attrfieldnames as $attr_name => $attr_description): ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"  for='<?php echo $attr_name; ?>'><?php echo $attr_description['description'] . ($attr_description['mandatory'] == 'Y' ? '*' : '') ?>:</label>
                            <div class="col-sm-10">
                                <input type='text' size='55' id='<?php echo $attr_name; ?>' name='<?php echo $attr_name; ?>' value='<?php if (isset($$attr_name)){echo htmlspecialchars($$attr_name, ENT_QUOTES, 'UTF-8');}?>' />
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>




            <!-- Buttons -->
            <p>
                <?php
                switch ($subaction)
                {
                    case "edit":
                        ?>
                        <input type='submit' class="hidden" value='<?php eT("Update token entry"); ?>' />
                        <input type='hidden' name='subaction' value='updatetoken' />
                        <input type='hidden' name='tid' value='<?php echo $tokenid; ?>' />
                        <?php break;
                    case "addnew": ?>
                        <input type='submit' class='hidden' value='<?php eT("Add token entry"); ?>' />
                        <input type='hidden' name='subaction' value='inserttoken' />
                        <?php break;
                } ?>
                <input type='hidden' name='sid' value='<?php echo $surveyid; ?>' />
            </p>
            </form>
        </div>
    </div>
</div>

<!--
    Script must remains inline !
    Don't attach it as an external file with CScript !

    NB: This view can be provided via ajax for the editing popup of the token grid.
    It's called with processOutput off, to avoid to reload jQuery. Else, if jQuery is reloaded,
    the object $.fn.yiiGridView is lost, and the table can't be updated.

    TODO: extend CController to provide a renderPartial method able to process all javascript less jQuery
    see: http://www.yiiframework.com/doc/api/1.1/CController#renderPartial-detail
 -->

<script>
    $('#sent-yes-no-date-container').YesNoDate();
    $('#remind-yes-no-date-container').YesNoDate();
</script>
