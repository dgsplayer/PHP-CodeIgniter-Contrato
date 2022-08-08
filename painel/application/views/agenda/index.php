<div class="content">
    <div class="main-header">
        <h2>Agenda de Compromissos</h2>
        <em>Abaixo sua agenda de tarefas</em>
    </div>
    <div class="main-content">

        <?php
        $user = $this->session->userdata('contrato_user');

//        $strPes   = "select  * from evenement WHERE id_usuario = '" . $_SESSION['id_usuario'] . "' and ((start = curdate() OR end = curdate()) or (start < curdate() and end > curdate()) ) ; ";
  //      $qryLogs  = mysql_query( $strPes ) or die ( mysql_error() . "<br>" . $strPes );
    //    $countCompromissos = mysql_num_rows($qryLogs);
        ?>
        <script>
            $(document).ready(function() {
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: "/painel/agenda/calendar_events",
                    // Convert the allDay from string to boolean
                    eventRender: function(event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDay) {
                        var title = prompt('Nome do Evento:');
                        //var url = prompt('Type Event url, if exits:');
                        if (title) {
                            var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
                            var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
                            //var id_session = '<?php  echo ($user['id_pessoa']);?>';
                            $.ajax({
                                url: "/painel/agenda/calendar_add_events",
                                data: 'title='+ title+'&start='+ start +'&end='+ end  ,
                                type: "POST",
                                success: function(json) {
                                    //alert('Adicionado com Sucesso.');
                                    parent.parent.footer.location.reload();
                                    window.location.reload();
                                }
                            });
                            calendar.fullCalendar('renderEvent',
                                    {
                                        title: title,
                                        start: start,
                                        end: end,
                                        allDay: allDay
                                    }
                                    ,true // make the event "stick"
                            );
                        }
                        calendar.fullCalendar('unselect');
                    },
                    editable: true,
                    eventDrop: function(event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                        $.ajax({
                            url: "/painel/agenda/calendar_update_events",
                            data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
                            type: "POST",
                            success: function(json) {
                                // alert("Atualizado com Sucesso");
                                parent.parent.footer.location.reload();
                                window.location.reload();
                            }
                        });
                    },
                    eventResize: function(event) {
                        var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                        $.ajax({
                            url: "/painel/agenda/calendar_update_events",
                            data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
                            type: "POST",
                            success: function(json) {
                                //  alert("Atualizado com Sucesso");
                                parent.parent.footer.location.reload();
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        </script>
        <style>
            #calendar {
                width: auto;
                padding: 10px;
                margin: 0 auto;
            }
        </style>
        <?php
      //  if($countCompromissos > 0){ ?>
<!--        <div class="alert" style="margin-left: 10px; margin-right: 10px;">Você tem <b>--><?php //// echo ($countCompromissos);?><!--</b> compromisso(s) agendado(s) para hoje!</div>-->
            <?php // }
        ?>
        <?php if($mensagem = $this->session->flashdata("error")) {  ?>
        <div class="alert alert-error bg-danger text-center">
            <?php echo $mensagem; ?>
        </div>
        <?php } ?>
        <div id='calendar'></div>

    </div>
    <!-- /main-content -->
</div>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/fullcalendar.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-components.js'); ?>"></script>