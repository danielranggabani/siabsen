<script setup lang="ts">
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kantor',
        href: '/kantor',
    },
];

const props = defineProps({
    kantor: Array<any>,
});

const form = useForm();

const handleDelete = (id) => {
    if (confirm('Apakah Anda Yakin Ingin Menghapus Quiz Ini?')) {
        form.delete('/kantor/' + id);
    }
};
</script>

<template>
    <Head title="Kantor" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card class="m-4 gap-0 p-4">
            <h1 class="text-3xl font-extrabold">List Kantor</h1>
            <p class="text-muted-foreground">Lint Kantor Yang Sudah Di Buat</p>
            <Link :href="route('kantor.create')" class="mt-2"><Button>Create New Kantor</Button></Link>

            <template v-if="$page.props.flash?.message">
                <Alert class="mt-4 border-green-500">
                    <AlertTitle>Notification</AlertTitle>
                    <AlertDescription>{{ $page.props.flash?.message }}</AlertDescription>
                </Alert>
            </template>

            <template v-for="(k, index) in props.kantor" :key="index">
                <Card class="m-4 mt-4 flex flex-row justify-between gap-0 bg-sidebar p-4">
                    <div class="container-text">
                        <h1 class="text-xl font-extrabold">{{ k.name }}</h1>
                        <p class="text-muted-foreground">{{ k.lokasi }}</p>
                    </div>
                    <div class="container-button space-x-1.5 pt-2">
                        <Link :href="route('kantor.show', k.id)" class="mt-2"><Button>View</Button></Link>
                        <Link :href="route('kantor.edit', k.id)" class="mt-2"><Button variant="secondary">Edit</Button></Link>
                        <Button variant="destructive" @click="handleDelete(k.id)">Delete</Button>
                        <img :src="k.qr_code" alt="" class="w-52 pt-5" />
                    </div>
                </Card>
            </template>
        </Card>
    </AppLayout>
</template>
