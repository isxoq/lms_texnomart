<div class="container">
	<div class="row">
		<br><br>
		<div class="col-md-6"><span style="font-size: 17px; font-weight: 900"><b>Farg'ona Shahar iSoft Kompaniyasiga<br> Vebsite orqali tushgan murojaat</b> <img style="margin: -30px 0px 0px 90px" src="/images/isoft.png"></span></div>
		<br><br>
		<table border="1px">
			<tr >
				<td style="font-size: 16px; font-weight: bold;">Murojaat tartib raqami</td>
				<td style="padding-left: 20px"><?=$model->id?></td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold;">Murojaat kelgan vaqti</td>
				<td style="padding-left: 20px"><?= date("H:m d-m-Y", $model->created_at)?> й</td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold;">Murojaatchi ismi</td>
				<td style="padding-left: 20px"><?=$model->firstname?></td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold;">Murojaatchi familiyasi</td>
				<td style="padding-left: 20px"><?=$model->lastname?></td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold;">Telefeon raqami</td>
				<td style="padding-left: 20px"><?=$model->phone?></td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold;">Elektron pochta manzili</td>
				<td style="padding-left: 20px"><?=$model->email?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size: 16px; font-weight: bold;">Мурожаатнинг қисқача мазмуни : </td>
			</tr>
		</table>
		<p style="text-indent: 50px; text-align: justify; font-size: 14px; line-height: 1.5" ><?= $model->body?></p>		
        <div class="col-md-offset-8 col-md-4 pull-right" style="padding-left: 500px;"><strong>
        
	</div>
	
</div>