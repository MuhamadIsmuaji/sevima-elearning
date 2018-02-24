<section class="hero is-light is-bold has-text-centered">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">Selamat datang di Sevima E-Learning</h1>
      <h2 class="subtitle">Kamu dapat belajar ilmu pengetahuan apapun disini.</h2>
    </div>
  </div>
</section>

<div class="container section">
  <div class="columns">
      <div class="column is-12">
          <?php $this->load->view('error_msg/index') ?>
      </div>
  </div>
  <div class="columns">
      <div class="column is-12">
          <nav class="pagination" role="navigation" aria-label="pagination"></nav>
      </div>
  </div>
  <div id="all_courses"></div>
</div>

<script src="<?php echo base_url('assets/js/listdata.js'); ?>"></script>

<script>
    link = [
        '<?php echo base_url('courses/getAll'); ?>',
    ];
    
    var courses = new List(link, "allCourses");

    function load(page) {
        courses.reload(page);
    } 

    $(() => {
        courses.reload(1);
    });
</script>