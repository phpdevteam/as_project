 <script src="../jquery/autocomplete/chosen.jquery.js" type="text/javascript"></script>
  <script src="../jquery/autocomplete/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : { width:"90%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>