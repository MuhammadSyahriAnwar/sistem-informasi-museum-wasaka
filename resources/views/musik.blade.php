<style>
    /* --- TOMBOL MUSIK FLOATING (ANTI TERTUTUP) --- */
    #btnWasakaMusic {
        position: fixed; 
        bottom: 30px; 
        left: 30px; 
        z-index: 999999 !important; /* Paksa selalu di paling atas layar! */
        background-color: #1a1a1a; 
        color: #C5A059; 
        width: 50px; 
        height: 50px;
        border-radius: 50%; 
        border: 2px solid #C5A059; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    #btnWasakaMusic:hover { 
        background-color: #C5A059; 
        color: #1a1a1a; 
        transform: scale(1.1); 
    }
    @media (max-width: 768px) {
        #btnWasakaMusic {
            bottom: 20px;
            left: 20px;
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
    }
</style>

<audio id="audioWasaka" loop preload="auto">
    <source src="{{ asset('audio/instrumen-banjar.mp3') }}" type="audio/mpeg">
</audio>

<button id="btnWasakaMusic" onclick="putarMusikWasaka()" title="Putar Musik Banjar">
    <i class="bi bi-volume-mute-fill" id="ikonWasaka"></i>
</button>

<script>
    // Fungsi khusus yang kebal dari error halaman lain
    function updateIkonWasaka(isPlaying) {
        const ikon = document.getElementById("ikonWasaka");
        if (!ikon) return; // Mencegah error null
        if(isPlaying) {
            ikon.classList.remove("bi-volume-mute-fill");
            ikon.classList.add("bi-volume-up-fill");
        } else {
            ikon.classList.remove("bi-volume-up-fill");
            ikon.classList.add("bi-volume-mute-fill");
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const lagu = document.getElementById("audioWasaka");
        if (!lagu) return;

        const isPlaying = localStorage.getItem('musicStatus');
        const savedTime = localStorage.getItem('musicTime');

        if (savedTime) {
            lagu.currentTime = parseFloat(savedTime);
            lagu.addEventListener('canplay', () => {
                if(lagu.currentTime < 1) { 
                    lagu.currentTime = parseFloat(savedTime);
                }
            }, { once: true });
        }

        if (isPlaying === 'true') {
            let playPromise = lagu.play();
            if (playPromise !== undefined) {
                playPromise.then(_ => {
                    updateIkonWasaka(true);
                }).catch(error => {
                    updateIkonWasaka(false);
                    localStorage.setItem('musicStatus', 'false');
                });
            }
        } else {
            updateIkonWasaka(false);
        }

        // Rekam waktu putar secara real-time
        lagu.addEventListener('timeupdate', () => {
            localStorage.setItem('musicTime', lagu.currentTime);
        });
    });

    // Nama fungsi diganti total agar tidak mengeksekusi script hantu
    function putarMusikWasaka() {
        const lagu = document.getElementById("audioWasaka");
        if (!lagu) return;

        if (lagu.paused) {
            lagu.play();
            localStorage.setItem('musicStatus', 'true');
            updateIkonWasaka(true);
        } else {
            lagu.pause();
            localStorage.setItem('musicStatus', 'false');
            updateIkonWasaka(false);
        }
    }
</script>