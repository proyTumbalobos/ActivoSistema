<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO INCIDENCIA</title>
    <link rel="stylesheet" href="css/InicioIncidencia.css">
</head>

<body>
    <div class="form-background">
        <div class="form-container">
            <div class="header">
                <h1>Registrar Incidencia</h1>
            </div>
            
            <form action="{{route('reg.inci')}}" method="POST" id="ticketForm">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>

                <div class="form-group">
                    <label for="area">Área</label>
                    <select class="form-control" name="id_area" id="id_area" required>
                        
                        @foreach ($areas as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="sede">Sede</label>
                    <select class="form-control" name="id_sede" id="id_sede" required>
                        
                        @foreach ($sedes as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción del Problema</label>
                    <textarea class="form-control" name="detalle" id="detalle" rows="4" required></textarea>
                </div>

                

                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>

    {{-- <script>
        document.getElementById('ticketForm').onsubmit = function (e) {
            e.preventDefault(); // Evitar envío por defecto

            const nombre = document.getElementById('nombre').value;
            const area = document.getElementById('area').value;
            const descripcion = document.getElementById('descripcion').value;
            const sede = document.getElementById('sede').value;
            const fecha = new Date().toLocaleString(); // Fecha y hora actual

            // Aquí puedes hacer una petición a tu backend para guardar la incidencia
            // Por simplicidad, lo mostraremos en consola
            console.log({
                nombre,
                area,
                descripcion,
                sede,
                fecha
            });

            // Resetear el formulario
            this.reset();
            alert('Se le notificó al equipo de TI, enseguida resolverán tu incidencia.');
            
        }
    </script> --}}
</body>

</html>
