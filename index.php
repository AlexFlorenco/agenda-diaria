<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../agenda/styles.css">
    <title>Agenda</title>
</head>

<body>
    <?php
    $conexao = new PDO("mysql:host=localhost; dbname=agenda_diaria", "root", "");

    $insert = "INSERT INTO tarefas VALUES (null, ?, ?)";
    $select = "SELECT id, DATE_FORMAT(horario, '%H:%i'), tarefa FROM tarefas";

    if (isset($_POST['tarefa'])) {
        $prepare = $conexao->prepare($insert);
        $prepare->execute([$_POST['horario'], $_POST['tarefa']]);
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conexao->exec("DELETE FROM tarefas WHERE id=$id");
    }

    $prepare = $conexao->prepare($select);
    $prepare->execute();

    $fetchTarefas = $prepare->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <h1>AGENDA DIÁRIA</h1>
        <form action="" method="post">
            <div class="input-group mb-3">
                <div class="form-floating form-tarefa">
                    <input type="text" name="tarefa" class="form-control tarefa" placeholder="Tarefa" id="floatingInputGroup1" required>
                    <label for="floatingInputGroup1">Tarefa</label>
                </div>

                <div class="form-floating form-horario">
                    <input type="time" name="horario" class="form-control horario" placeholder="Horário" id="floatingInputGroup2" required>
                    <label for="floatingInputGroup2">Horário</label>

                </div>
                <div class="form-btn d-grid">
                    <button class="btn btn-outline-primary form-control" type="submit">Adicionar</button>
                </div>
            </div>

        </form>
        <div class="lista">
            <?php
            foreach ($fetchTarefas as $value) {
                echo '<div class="item"><p><b>' . $value["DATE_FORMAT(horario, '%H:%i')"] . '</b> - ' . $value['tarefa'] . '<a href="?delete=' . $value['id'] . '"></p><button class="btn btn-outline-success"><i class="bi bi-check"></i></button></a> ' . '</div>';
            }
            ?>

        </div>
    </div>
</body>

</html>