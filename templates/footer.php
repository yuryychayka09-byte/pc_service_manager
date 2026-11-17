<footer class="footer mt-5">

    <div class="container text-center">

        <p class="mb-1">
            PC Service Manager
        </p>

        <p class="mb-1">
            Розробник: Юрій Чайка
        </p>

        <p class="mb-0">
            © 2026
        </p>

    </div>
<script>

const themeToggle =
document.getElementById('themeToggle');

if(localStorage.getItem('theme') === 'light'){

    document.body.classList.add('light-theme');

}

if(themeToggle){

    themeToggle.addEventListener('click', () => {

        document.body.classList.toggle('light-theme');

        if(document.body.classList.contains('light-theme')){

            localStorage.setItem('theme', 'light');

        }
        else{

            localStorage.setItem('theme', 'dark');

        }

    });

}

</script>
</footer>