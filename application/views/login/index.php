<section class="hero is-primary is-bold has-text-centered">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Silakan Login</h1>
            <h2 class="subtitle">Masuk dan berkumpullah dengan kawan kawan developer keren lainnya !</h2>
        </div>
    </div>
</section>

<div class="container section">
    <div class="columns">
        <div class="column is-6 is-offset-3">
            <h1 class="is-size-3">Masuk Kawan Koding</h1>            
            <div class="box">
                <?php $this->load->view('error_msg/index') ?>
                <form method="post" action="<?= base_url('login') ?>">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-right">
                        <div class="control">
                            <input type="submit" value="Masuk" class="is-pulled-right button is-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>