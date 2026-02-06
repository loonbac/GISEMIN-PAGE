// Contenido rotativo para cada tarjeta de servicio - 8 servicios (distribuidos en 4 tarjetas)
const servicesContent = [
    // Tarjeta 1 - 2 servicios
    [
        {
            image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80",
            title: "IMPLEMENTACIÓN DE SISTEMAS DE GESTIÓN",
            description: ""
        },
        {
            image: "https://meiningenieros.pe/wp-content/uploads/2025/05/monitoreo-de-agentes-fisicos-quimicos-biologicos-y-ergonomicos.webp",
            title: "MONITOREO DE HIGIENE OCUPACIONAL",
            description: ""
        },
        {
            image: "https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=600&q=80",
            title: "AUDITORÍA DE CUMPLIMIENTO Y MEJORA",
            description: ""
        }
    ],
    // Tarjeta 2 - 2 servicios
    [
        {
            image: "https://images.unsplash.com/photo-1553028826-f4804a6dba3b?w=600&q=80",
            title: "CONSULTORÍA SENIOR ESPECIALIZADA",
            description: ""
        },
        {
            image: "https://images.unsplash.com/photo-1568992687947-868a62a9f521?w=600&q=80",
            title: "GESTIÓN DE EXPEDIENTES INDECI (ITSE)",
            description: ""
        }
    ],
    // Tarjeta 3 - 2 servicios
    [
        {
            image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&q=80",
            title: "FORMACIÓN Y ENTRENAMIENTO DE ALTO IMPACTO",
            description: ""
        },
        {
            image: "https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&q=80",
            title: "SUMINISTRO DE EPP Y EQUIPAMIENTO TÉCNICO",
            description: ""
        }
    ],
    // Tarjeta 4 - 2 servicios
    [
        {
            image: "https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=600&q=80",
            title: "OUTSOURCING ESTRATÉGICO DE PERSONAL",
            description: ""
        },
        {
            image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80",
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
