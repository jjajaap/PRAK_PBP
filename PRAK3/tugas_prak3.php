<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <?php
    // Inisialisasi variabel error dan input
    $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_ekstrakurikuler = "";
    $nis = $nama = $jenis_kelamin = $kelas = "";
    $ekstrakurikuler = [];

    // Fungsi untuk membersihkan input
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Proses validasi saat form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validasi NIS
        $nis = test_input($_POST['nis']);
        if (empty($nis)) {
            $error_nis = "NIS harus diisi";
        } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
            $error_nis = "NIS harus terdiri dari 10 angka";
        }

        // Validasi Nama
        $nama = test_input($_POST['nama']);
        if (empty($nama)) {
            $error_nama = "Nama harus diisi";
        }

        // Validasi Jenis Kelamin
        if (empty($_POST['jenis_kelamin'])) {
            $error_jenis_kelamin = "Jenis kelamin harus diisi";
        } else {
            $jenis_kelamin = $_POST['jenis_kelamin'];
        }

        // Validasi Kelas
        if (empty($_POST['kelas'])) {
            $error_kelas = "Kelas harus dipilih";
        } else {
            $kelas = $_POST['kelas'];
        }

        // Validasi Ekstrakurikuler (Jika kelas X atau XI)
        if (($kelas == 'X' || $kelas == 'XI') && empty($_POST['ekstrakurikuler'])) {
            $error_ekstrakurikuler = "Pilih minimal 1 ekstrakurikuler";
        } elseif (!empty($_POST['ekstrakurikuler'])) {
            $ekstrakurikuler = $_POST['ekstrakurikuler'];
            if (count($ekstrakurikuler) < 1 || count($ekstrakurikuler) > 3) {
                $error_ekstrakurikuler = "Pilih minimal 1 dan maksimal 3 ekstrakurikuler";
            }
        }
    }
    ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">Form Input Siswa</div>
            <div class="card-body">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="nis">NIS:</label>
                        <input type="text" class="form-control" id="nis" name="nis" maxlength="10" oninput="checkNISLength(this)"
                            value="<?php echo $nis; ?>">
                        <div class="text-danger"><?php echo $error_nis; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                        <div class="text-danger"><?php echo $error_nama; ?></div>
                    </div>
                    <label>Jenis Kelamin:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria" <?php if ($jenis_kelamin == 'Pria') echo 'checked'; ?>>
                        <label class="form-check-label">Pria</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita" <?php if ($jenis_kelamin == 'Wanita') echo 'checked'; ?>>
                        <label class="form-check-label">Wanita</label>
                    </div>
                    <div class="text-danger"><?php echo $error_jenis_kelamin; ?></div>
                    <div class="form-group mt-3">
                        <label for="kelas">Kelas:</label>
                        <select id="kelas" name="kelas" class="form-control" onchange="toggleEkstrakurikuler()">
                            <option value="">Pilih Kelas</option>
                            <option value="X" <?php if ($kelas == 'X') echo 'selected'; ?>>X</option>
                            <option value="XI" <?php if ($kelas == 'XI') echo 'selected'; ?>>XI</option>
                            <option value="XII" <?php if ($kelas == 'XII') echo 'selected'; ?>>XII</option>
                        </select>
                        <div class="text-danger"><?php echo $error_kelas; ?></div>
                    </div>
                    <div id="ekstrakurikuler-section" style="display: <?php echo ($kelas == 'X' || $kelas == 'XI') ? 'block' : 'none'; ?>;">
                        <label>Ekstrakurikuler:</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Pramuka" <?php if (in_array('Pramuka', $ekstrakurikuler)) echo 'checked'; ?>>
                            <label class="form-check-label">Pramuka</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Seni Tari" <?php if (in_array('Seni Tari', $ekstrakurikuler)) echo 'checked'; ?>>
                            <label class="form-check-label">Seni Tari</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Sinematografi" <?php if (in_array('Sinematografi', $ekstrakurikuler)) echo 'checked'; ?>>
                            <label class="form-check-label">Sinematografi</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Basket" <?php if (in_array('Basket', $ekstrakurikuler)) echo 'checked'; ?>>
                            <label class="form-check-label">Basket</label>
                        </div>
                        <div class="text-danger"><?php echo $error_ekstrakurikuler; ?></div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // // Fungsi untuk memeriksa panjang input NIS
        // function checkNISLength(input) {
        //     if (input.value.length > 10) {
        //         alert("NIS hanya boleh berisi 10 angka.");
        //         input.value = input.value.slice(0, 10); // Memotong input agar tidak lebih dari 10 angka
        //     }
        // }

        // Fungsi untuk menampilkan atau menyembunyikan bagian ekstrakurikuler
        function toggleEkstrakurikuler() {
            const kelas = document.getElementById('kelas').value;
            const ekstrakurikulerSection = document.getElementById('ekstrakurikuler-section');

            if (kelas === 'X' || kelas === 'XI') {
                ekstrakurikulerSection.style.display = 'block'; // Tampilkan jika kelas X atau XI
            } else {
                ekstrakurikulerSection.style.display = 'none'; // Sembunyikan jika kelas XII
            }
        }
    </script>
</body>

</html>