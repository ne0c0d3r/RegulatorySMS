        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top std-bg-linear-grad" role="navigation" style="margin-bottom: 0">

          <?php 
            $this->load->view('top-nav');
            $data = '';
            if (isset($assignData)) {
            	$data = $assignData;
            }
            $this->load->view('side-nav', $data);
          ?>

        </nav>