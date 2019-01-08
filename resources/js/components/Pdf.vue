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
        props: ['user'],
        methods: {
            genPdf()
            {
                console.log('Generating PDF...');

                /**
                 * New document
                 */
                var doc = new jsPDF();

                /**
                 * Add title
                 */
                doc.text(20, 20, this.user.name);

                /**
                 * Write HTML from #pdfContent to document
                 */
                doc.fromHTML($('#pdfContent').get(0), 20, 30, {
                    width: 160
                });

                /**
                 * Save
                 */
                doc.save(this.user.name + '.pdf');
            },
        },
    }
</script>
