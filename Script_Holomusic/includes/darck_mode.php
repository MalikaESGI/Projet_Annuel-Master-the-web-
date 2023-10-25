<style>
    label {
        position: absolute;
        width: 45px;
        height: 22px;
        right: 200px;
        top: 20px;
        z-index:5; 
        border: 2px solid;
        border-radius: 20px;
    }

    label:before {
        position: absolute;
        content: '';
        width: 20px;
        height: 20px;
        left: 1px;
        top: 1px;
        border-radius: 50%;
        background: #fff;
        cursor: pointer;
        transition: 0.4s;
    }

    label.active:before {
        left: 24px;
        background: #000;
    }

    body.night {
        background: #fff;
        color: #000;
    }

    h1 {
        transition: color 0.4s;
    }

    body.night h1 {
        color: #000;
    }

    h1.night {
        color: #000;
    }

</style>

<script>
    var content = document.getElementsByTagName('body')[0];
    var darkMode = document.getElementById('dark-change');
    darkMode.addEventListener('click', function () {
        darkMode.classList.toggle('active');
        content.classList.toggle('night');

        var titles = document.getElementsByTagName('h1');
        for (var i = 0; i < titles.length; i++) {
            titles[i].classList.toggle('night');
        }
    });
</script>
