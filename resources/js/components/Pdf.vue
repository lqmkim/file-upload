<template>
    <div>
        <div id="pdfContent">
            <slot></slot>
        </div>
        <button @click="genPdf">Ganerate PDF</button>
    </div>
</template>

<script>
    export default {
        methods: {
            genPdf()
            {
                console.log('Generating PDF...');

                var doc = new jsPDF();

                let margins = {top: 20, bottom: 20, left: 20, width: 20};

                doc.fromHTML($('#pdfContent').get(0), 20, 20, {
                    width: 160
                });

                doc.save('gen.pdf');
            },
        },
    }
</script>
