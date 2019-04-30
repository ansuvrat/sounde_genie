<div class="content">

	<div id="content">

		<div class="breadcrumb">

			<?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> 

		</div>

		

		<div class="box">

			<div class="heading">

				<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

				

				<div class="buttons">

					<a href="<?php echo $cancel_url;?>" class="button">Cancel</a> 

				</div>

			</div>

			

			<div class="content">

				<?php echo validation_message();?>

				<?php echo error_message(); ?>

				

				<?php echo form_open_multipart("sitepanel/faq/add");?>

				<div id="tab_pinfo">

					<table width="90%"  class="form"  cellpadding="3" cellspacing="3">

						<tr>

							<th colspan="2" align="center" > </th>

						</tr>

						

           

						<tr class="trOdd">

							<td width="28%" height="26" align="right" ><span class="required">*</span> Question:</td>

							<td width="72%" align="left"><input type="text" name="question" size="90" value="<?php echo set_value('question',$this->input->post('question'));?>"></td>

						</tr>

            <tr class="trEven">

                <td width="28%" height="26" align="right">Answer :<span class="required">*</span> </td>

                <td width="72%" align="left">

                <textarea name="answer" rows="5" cols="50" id="answer" ><?php echo set_value('answer');?></textarea>

                <?php  echo display_ckeditor($ckeditor); ?>

                </td>

            </tr>

						<tr class="trOdd">

							<td align="left">&nbsp;</td>

							<td align="left">

                                <input type="hidden" name="pack_title" value="1" />

								<input type="hidden" name="action" value="addcategory" />

								<input type="submit" name="sub" value="Add" class="button2" />

							</td>

						</tr>

					</table>

				</div>

				<?php echo form_close(); ?>

			</div>

		</div>

		

	</div>

</div>	