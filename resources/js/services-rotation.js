// Contenido rotativo para cada tarjeta de servicio - 8 servicios (distribuidos en 4 tarjetas)
const servicesContent = [
    // Tarjeta 1 - 3 servicios
    [
        {
            image: "/images/servicios/implementacion_de_sistemas_de_gestion.png",
            title: "IMPLEMENTACIÓN DE SISTEMAS DE GESTIÓN",
            description: ""
        },
        {
            image: "/images/servicios/monitoreo_de_higiene_ocupacional.png",
            title: "MONITOREO DE HIGIENE OCUPACIONAL",
            description: ""
        },
        {
            image: "/images/servicios/auditoria_de_cumplimiento_y_mejora.png",
            title: "AUDITORÍA DE CUMPLIMIENTO Y MEJORA",
            description: ""
        }
    ],
    // Tarjeta 2 - 2 servicios
    [
        {
            image: "/images/servicios/consultoria_senior_especializada.png",
            title: "CONSULTORÍA SENIOR ESPECIALIZADA",
            description: ""
        },
        {
            image: "/images/servicios/gestion_de_expedientes_indeci_itse.png",
            title: "GESTIÓN DE EXPEDIENTES INDECI (ITSE)",
            description: ""
        }
    ],
    // Tarjeta 3 - 2 servicios
    [
        {
            image: "/images/servicios/formacion_entrenamiento_de_alto_impacto.png",
            title: "FORMACIÓN Y ENTRENAMIENTO DE ALTO IMPACTO",
            description: ""
        },
        {
            image: "/images/servicios/suministro_de_epp_y_equipamiento_tecnico.png",
            title: "SUMINISTRO DE EPP Y EQUIPAMIENTO TÉCNICO",
            description: ""
        }
    ],
    // Tarjeta 4 - 2 servicios
    [
        {
            image: "/images/servicios/outsourcing_estrategico_de_personal.png",
            title: "OUTSOURCING ESTRATÉGICO DE PERSONAL",
            description: ""
        },
        {
            image: "/images/servicios/implementacion_de_sistemas_de_gestion.png",
            title: "IMPLEMENTACIÓN DE SISTEMAS DE GESTIÓN",
            description: ""
        }
    ]
];

let currentIndexes = [0, 0, 0, 0];

function rotateServiceContent() {
    const serviceCards = document.querySelectorAll('.service-card');

    serviceCards.forEach((card, cardIndex) => {
        // Delay escalonado para cada tarjeta (300ms entre cada una)
        setTimeout(() => {
            // Incrementar índice de contenido para esta tarjeta
            currentIndexes[cardIndex] = (currentIndexes[cardIndex] + 1) % servicesContent[cardIndex].length;

            const content = servicesContent[cardIndex][currentIndexes[cardIndex]];

            // Agregar clase de fade out
            card.classList.add('service-fade');

            // Después de la animación de fade out, cambiar el contenido
            setTimeout(() => {
                const img = card.querySelector('.service-image img');
                const title = card.querySelector('.service-info h3');
                const description = card.querySelector('.service-info p');

                img.src = content.image;
                img.alt = content.title;
                title.textContent = content.title;
                if (description) {
                    description.textContent = content.description;
                }

                // Quitar clase de fade para mostrar nuevo contenido con fade in
                card.classList.remove('service-fade');
            }, 500);
        }, cardIndex * 300);
    });
}

// Iniciar rotación automática cada 16 segundos
setInterval(rotateServiceContent, 16000);
