<div class="row">
	<div class="page-bar">
		<ul class="page-breadcrumb pull-right">
			<li>
				<span class="">Yesterday Closing
					:
					<?php 
					  if($arrival_yesterday['crate'] > $dispatch_yesterday['crate'])
					  {
					  	echo $arrival_yesterday['crate'] - $dispatch_yesterday['crate'];
					  }
					  else
					  {
					  	echo $dispatch_yesterday['crate'] - $arrival_yesterday['crate'];
					  }
	                ?>
            	</span>
			</li>
		</ul>
	</div>
	<div class="col-lg-3">
		<div class="dashboard-stat green-haze">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php 
						echo $arrival_today['crate'];
                    ?>
				</div>
				<div class="desc">
					 Arrival(Today)
				</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php
						echo $dispatch_today['crate'];
                    ?>
				</div>
				<div class="desc">
					 Dispatch(Today)
				</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="dashboard-stat red-intense">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php
						$yesterday_closing=$arrival_yesterday['crate'] - $dispatch_yesterday['crate'];
						echo $yesterday_closing + $arrival_today['crate'] - $dispatch_today['crate'];
					?>
				</div>
				<div class="desc">
					 Current Stock
				</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="dashboard-stat purple-plum">
			<div class="visual">
				<i class="fa fa-globe"></i>
			</div>
			<div class="details">
				<div class="number">
					<?= $empty_carton_in['total_quantity'] - $empty_carton_out['total_quantity']?>
				</div>
				<div class="desc">
					 Current Empty Crates
				</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Expiry Product Report') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col"><?= __('Product') ?></th>
                            <th scope="col"><?= __('Weight') ?></th>
                            <th scope="col"><?= __('Available Quantity') ?></th>
                            <th scope="col"><?= __('Expire(In days)') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($data as $transaction):
                            $now = time(); // or your date as well
                            $your_date = strtotime($transaction->expiry_date);
                            $datediff =$your_date - $now;

                            $two_month=round($datediff / (60 * 60 * 24));
                            if($two_month <= 60)
                            {
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $transaction->name?></td>
                            <td><?= $transaction->weight?></td>
                            <td><?php
                                   echo $transaction->amount_sum / $transaction->box_in_crate;
                                 ?>
                                 </td>
                            <td><?= $two_month ?></td>
                        </tr>
                        <?php }endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>