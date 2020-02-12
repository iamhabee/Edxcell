<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-book"></i> <?=$this->lang->line('panel_title1')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_note')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <?php if(permissionChecker('note_add')) { ?>
                    <h5 class="page-header">
                        <a href="<?php echo base_url('note/add') ?>">
                            <i class="fa fa-plus"></i>
                            <?=$this->lang->line('add_note')?>
                        </a>
                    </h5>
                <?php } ?>
              <div id="hide-table">
                <?php if(count($notes)) {$i = 1; foreach($notes as $note) {
                  foreach ($subjects as $key => $subject) {
                    foreach ($subject as $key => $sub) {  ?>

                <div class="col-sm-3">
                      <div class="box box-primary">
                          <div class="box-body box-profile">
                              <h1 class="profile-username text-center"><?php echo $sub->subject ?> </h1>
                              <p class="text-muted text-center">study of human</p>
                              <?php if(permissionChecker('note_edit') || permissionChecker('note_delete') || permissionChecker('note_view')){
                                echo btn_edit('note/edit/'.$note->id, $this->lang->line('edit'));
                                echo btn_delete('note/delete/'.$note->id, $this->lang->line('delete'));
                              }?>
                              <a class="text-primary "float-right href="<?=base_url("note/read")?>" ><?=$this->lang->line("read_note")?></a>
                          </div>
                      </div>
                </div>
                <?php $i++; }}}} ?>

            </div> <!-- col-sm-12 -->
          </div>
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
