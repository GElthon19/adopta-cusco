<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalesSeeder extends Seeder
{
    public function run()
    {
        // Solo ejecutar si no hay animales en la BD
        if (DB::table('animales')->count() > 0) {
            $this->command->info('Los animales ya existen en la base de datos. Saltando seeder...');
            return;
        }

        $animales = [
            [
                'nombre' => 'Luna',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Rescatada de un tejado en Llantaytambo, aún se asusta con ruidos fuertes.',
                'estado' => 'Disponible',
                'imagen' => 'gatLuna.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Simon',
                'especie' => 'Gato',
                'edad' => 3,
                'descripcion' => 'Perdió una pata tras ser atropellado, pero salta y juega como cualquiera.',
                'estado' => 'Disponible',
                'imagen' => 'gatSimon.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Mia',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Encontrada dentro de una caja en el mercado, necesita mucho calor humano.',
                'estado' => 'Disponible',
                'imagen' => 'gatMia.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Olivia',
                'especie' => 'Gato',
                'edad' => 4,
                'descripcion' => 'Su familia se mudó y la dejaron. Aún espera que la abracen de nuevo.',
                'estado' => 'Disponible',
                'imagen' => 'gatOlivia.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Thor',
                'especie' => 'Gato',
                'edad' => 2,
                'descripcion' => 'Fue maltratado por niños, pero ronronea apenas sientes confianza.',
                'estado' => 'Disponible',
                'imagen' => 'gatThor.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Coco',
                'especie' => 'Gato',
                'edad' => 6,
                'descripcion' => 'Se quedó sin hogar cuando su humano falleció. Busca un nuevo abuelo.',
                'estado' => 'Disponible',
                'imagen' => 'gatCoco.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Kira',
                'especie' => 'Gato',
                'edad' => 2,
                'descripcion' => 'Escapó de un incendio y sobrevivió 5 días escondida. Es muy cariñosa.',
                'estado' => 'Disponible',
                'imagen' => 'gatKira.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Nube',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Nació en la calle, le encanta dormir en tu regazo mientras trabajas.',
                'estado' => 'Disponible',
                'imagen' => 'gatNube.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Romeo',
                'especie' => 'Gato',
                'edad' => 3,
                'descripcion' => 'Le encanta mirar películas contigo. Fue rescatado de un basurero.',
                'estado' => 'Disponible',
                'imagen' => 'gatRomeo.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Cleo',
                'especie' => 'Gato',
                'edad' => 3,
                'descripcion' => 'Sobrevivió a un envenenamiento masivo. Aún confía en los humanos.',
                'estado' => 'Disponible',
                'imagen' => 'gatCleo.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Zoe',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Le falta un ojo por infección, pero eso no le impide cazar juguetitos.',
                'estado' => 'Disponible',
                'imagen' => 'gatZoe.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Arya',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Encontrada con hipotermia tras una granizada. Le encanta el calor de las cobijas.',
                'estado' => 'Disponible',
                'imagen' => 'gatArya.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Loki',
                'especie' => 'Gato',
                'edad' => 5,
                'descripcion' => 'Fue usado para cría intensiva. Ahora solo quiere dormir sin miedo.',
                'estado' => 'Disponible',
                'imagen' => 'gatLoki.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Misha',
                'especie' => 'Gato',
                'edad' => 1,
                'descripcion' => 'Perdió a sus gatitos y busca abrazar a cualquier humano que la mire.',
                'estado' => 'Disponible',
                'imagen' => 'gatMisha.webp',
                'fecha_ingreso' => '2025-10-26'
            ],
            [
                'nombre' => 'Zeus',
                'especie' => 'Perro',
                'edad' => 5,
                'descripcion' => 'Rescatado de una obra en abandono, ahora busca un hogar donde ser el guardián noble que siempre fue.',
                'estado' => 'Disponible',
                'imagen' => 'perZeus.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Coco',
                'especie' => 'Perro',
                'edad' => 3,
                'descripcion' => 'Perdió a su familia en un incendio, pero aún abre la cola al escuchar "¡vamos!", quiere correr de nuevo.',
                'estado' => 'Disponible',
                'imagen' => 'perCoco.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Rex',
                'especie' => 'Perro',
                'edad' => 1,
                'descripcion' => 'Encontrado en una caja junto al río, duerme abrazado a su peluche; necesita mami o papi humano.',
                'estado' => 'Disponible',
                'imagen' => 'perRex.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Tank',
                'especie' => 'Perro',
                'edad' => 10,
                'descripcion' => 'Se quedó sin dueño por fallecimiento; aún espera en la puerta. Ideal para casa tranquila y cariñosa.',
                'estado' => 'Disponible',
                'imagen' => 'perTank.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Simba',
                'especie' => 'Perro',
                'edad' => 4,
                'descripcion' => 'Sacado de peleas clandestinas, ha aprendido a confiar; le encanta jugar con pelotas y olvidar el pasado.',
                'estado' => 'Disponible',
                'imagen' => 'perSimba.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Lola',
                'especie' => 'Perro',
                'edad' => 6,
                'descripcion' => 'Vivió atada a un árbol 3 años; ahora mueve la cola solo de verte llegar. Busca sofá y manta.',
                'estado' => 'Disponible',
                'imagen' => 'perLola.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Nina',
                'especie' => 'Perro',
                'edad' => 2,
                'descripcion' => 'Escapó de un criadero intensivo, tiene miedo a la oscuridad, pero ronronea si la acaricias.',
                'estado' => 'Disponible',
                'imagen' => 'perNina.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Bolt',
                'especie' => 'Perro',
                'edad' => 3,
                'descripcion' => 'Rescatado de la carretera con pata fracturada; ya corre y salta, quiere acompañarte en tus caminatas.',
                'estado' => 'Disponible',
                'imagen' => 'perBolt.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Toto',
                'especie' => 'Perro',
                'edad' => 1,
                'descripcion' => 'Regalado y devuelto 3 veces por "travieso"; en realidad solo quiere jugar y aprender.',
                'estado' => 'Disponible',
                'imagen' => 'perToto.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Hera',
                'especie' => 'Perro',
                'edad' => 7,
                'descripcion' => 'Dejada en el albergue por "vieja"; aún tiene energía para paseos y abrazos infinitos.',
                'estado' => 'Disponible',
                'imagen' => 'perHera.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Spark',
                'especie' => 'Perro',
                'edad' => 2,
                'descripcion' => 'Encontrada con quemaduras de cigarrillo; aún así lame la mano que la acaricia. Merece amor de verdad.',
                'estado' => 'Disponible',
                'imagen' => 'perSpark.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Volt',
                'especie' => 'Perro',
                'edad' => 4,
                'descripcion' => 'Perdió un ojo defendiendo a su anterior familia; ahora defiende tu corazón con cola y lengua.',
                'estado' => 'Disponible',
                'imagen' => 'perVolt.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Lunita',
                'especie' => 'Perro',
                'edad' => 5,
                'descripcion' => 'Asustadiza con hombres altos; con mujeres y niños es un osito. Necesita paciencia y dulzura.',
                'estado' => 'Disponible',
                'imagen' => 'perLunita.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'León',
                'especie' => 'Perro',
                'edad' => 3,
                'descripcion' => 'Sacado de un laboratorio clandestino; nunca había visto el sol. Ahora lo busca en cada ventana.',
                'estado' => 'Disponible',
                'imagen' => 'perLeon.webp',
                'fecha_ingreso' => '2025-10-27'
            ],
            [
                'nombre' => 'Dana',
                'especie' => 'Perro',
                'edad' => 1,
                'descripcion' => 'Criada en un balcón minúsculo; aprendió a caminar en tierra al llegar al albergue. Quiere explorar contigo.',
                'estado' => 'Disponible',
                'imagen' => 'perDana.webp',
                'fecha_ingreso' => '2025-10-27'
            ]
        ];

        DB::table('animales')->insert($animales);
    }
}