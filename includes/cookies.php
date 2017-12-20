<!-- This script triggers the modal without a button -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#myModal").modal('show');
  });
</script>

<!-- Modal -->
<?php // NOTE: een modal is een popup venster. Gr Kai?>
<style media="screen">#myModal{top:38%;right:75%;outline: none;}</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Deze website maakt gebruik van cookies</h4>
      </div>
      <div class="modal-body">
        <p>Deze website gebruikt cookies voor een verbeterde gebruikservaring. Door gebruik te maken van onze website of door op "Ik ga akkoord" te klikken ga je akkoord met al onze cookies die benoemd zijn in ons cookie beleid.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Ik ga akkoord</button>
        <a type="button" href="cookiebeleid.pdf" class="btn btn-info" role="button">Lees meer</a>
      </div>
    </div>

  </div>
</div>
