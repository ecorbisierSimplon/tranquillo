<page>
    <actionBar title="Tranquillo | Home" />
    <gridLayout>
        <label class="info">
            <formattedString>
                <span class="fas" text="&#xf135;" />
                <span text=" {message}" />
            </formattedString>
        </label>
    </gridLayout>
</page>

<script lang="ts">
    let message: string = "Bonjour ma chérie ! :)"
</script>

<style lang="scss">


    .info {
        font-size: 20;
        horizontal-align: center;
        vertical-align: center;
        .fas {
        color: #3A53FF;
    }
    }
</style>
