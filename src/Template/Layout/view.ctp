<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Village $village
 */
?>
<style>
table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 5px;
}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
}
</style>
<div class="container-fluid">
    <table>
        <tr>
            <td colspan="4">PROJECT DETAILS</td>
        </tr>
        <tr>
            <td width="5%">1</td>
            <td width="40%">Name of Client</td>
            <td width="50%" colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">2</td>
            <td width="40%">Name of Contractor</td>
            <td width="50%" colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">3</td>
            <td width="40%">Name of Work</td>
            <td width="50%" colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">4</td>
            <td width="40%">Work Order Ref. No.</td>
            <td width="50%" colspan="2"></td>
        </tr>

        <!-- ************************************************************************************************** -->

        <tr>
            <td colspan="2">SITE INFORMATION</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">5</td>
            <td width="40%">Name of Village or Habitation</td>
            <td width="50%" colspan="2"><?= $village->name ?></td>
        </tr>
        <tr>
            <td width="5%">6</td>
            <td width="40%">GPS Co-ordinates of Site</td>
            <td width="50%" colspan="2"><?= $village->site_work->site_selection->gps_co_ordinates ?></td>
        </tr>
        <tr>
            <td width="5%">7</td>
            <td width="40%">Site Route With Appropriate Landmarks</td>
            <td width="50%" colspan="2"><?= $village->site_work->site_selection->lendmark ?></td>
        </tr>
        <tr>
            <td width="5%">8</td>
            <td width="40%">Block</td>
            <td width="50%" colspan="2"><?= $village->division->block->name ?></td>
        </tr>
        <tr>
            <td width="5%">9</td>
            <td width="40%">MLA Constituency</td>
            <td width="50%" colspan="2"><?= $village->site_work->site_selection->mla_constituency->name ?></td>
        </tr>
        <tr>
            <td width="5%">10</td>
            <td width="40%">Gram Panchayat</td>
            <td width="50%" colspan="2"><?= $village->site_work->site_selection->gram_panchayat->name ?></td>
        </tr>
        <tr>
            <td width="5%">11</td>
            <td width="40%">District</td>
            <td width="50%" colspan="2"><?= $village->division->block->district->name ?></td>
        </tr>
        <?php foreach ($village->do_villages as $key => $officer): ?>
            <tr>
                <td><?= $key+12 ?></td>
                <td>Concerned <?= $officer->post ?>, PHED (Name, Phone no. & Email)</td>
                <td width="50%" colspan="2"><?= $officer->name ?> <?= $officer->mobile ?> <?= $officer->email ?></td>
            </tr>
        <?php endforeach;?>
            
        <tr>
            <td width="5%">17</td>
            <td width="40%">Sarpanch (Name, Phone no. & Email)</td>
            <td width="50%" colspan="2"><?= $village->site_work->site_selection->sarpanch ?> <?= $village->site_work->site_selection->mobile ?> <?= $village->site_work->site_selection->email ?></td>
        </tr>
        
        <!-- ************************************************************************************************** -->

        <tr>
            <td colspan="2">PARAMETERS</td>
            <td colspan="2">DATE OF PARAMETER SURVEY: </td>
        </tr>    
        <tr>
            <td width="5%">18</td>
            <td width="40%">Borewell Availability</td>
            <td>
                <input type="checkbox" name="C1" value="C1" <?= $village->site_work->site_selection->borewell_available =='Yes' ? 'checked="checked"' : '' ?>> Yes
                <input type="checkbox" name="C2" value="C2" <?= $village->site_work->site_selection->borewell_available=='No' ? 'checked="checked"' : '' ?>> No
            </td>
            <td>Distance From Site: <?= $village->site_work->site_selection->borewell_distance.' '.$village->site_work->site_selection->borewell_unit ?></td>
        </tr>
        <tr>
            <td width="5%">19</td>
            <td width="40%">Raw Water TDS</td>
            <td colspan="2"><?= $village->site_work->site_selection->raw_water_tds ?></td>
        </tr>
        <tr>
            <td width="5%">20</td>
            <td width="40%">Raw Water Fluoride</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">21</td>
            <td width="40%">Separate Borewell Power Connection & Meter</td>
            <td>
                <input type="checkbox" name="C3" value="C3"> Yes
                <input type="checkbox" name="C4" value="C4"> No
            </td>
            <td>Distance From Site: </td>
        </tr>
        <tr>
            <td width="5%">22</td>
            <td width="40%">Separate Borewell Power Connection Load</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">23</td>
            <td width="40%">Separate RO Plant Power Connection & Meter</td>
            <td>
                <input type="checkbox" name="C5" value="C5"> Yes
                <input type="checkbox" name="C6" value="C6"> No
            </td>
            <td>Distance From Site: </td>
        </tr>
        <tr>
            <td width="5%">24</td>
            <td width="40%">Separate RO Plant Power Connection Load</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="5%">25</td>
            <td width="40%">Date Of Moter Lowering</td>
            <td colspan="2"><?= $village->site_work->site_selection->lendmark ?></td>
        </tr>
        <tr>
            <td width="5%">26</td>
            <td width="40%">Date Of Power Connection</td>
            <td colspan="2"><?= $village->division->block->name ?></td>
        </tr>
    </table>
    <?php $image = explode(',', $village->image); ?>
</div>