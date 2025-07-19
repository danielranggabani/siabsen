<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'CreateKantor',
        href: '/create-kantor',
    },
];

const form = useForm({
    name: '',
    lokasi: '',
});

const sendData = () => {
    form.post('/kantor');
};
</script>

<template>
    <Head title="Create Kantor" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Card class="m-4 gap-0 p-4">
            <h1 class="text-3xl font-extrabold">Create Kantor</h1>
            <p class="text-muted-foreground">Buat Kantor Baru</p>
            <Link :href="route('kantor.index')" class="mt-2"><Button variant="outline">Back</Button></Link>

            <!-- <template v-if="$page.props.flash?.message"> -->
            <!-- <Alert class="mt-4 border-green-500">
                    <AlertTitle>Notification</AlertTitle>
                    <AlertDescription>{{ $page.props.flash?.message }}</AlertDescription>
                </Alert> -->
            <!-- </template> -->
        </Card>

        <Card class="m-4 mt-0 gap-0 bg-sidebar p-4">
            <h1 class="text-xl font-extrabold">Form Create Quiz</h1>
            <form action="" @submit.prevent="sendData">
                <div class="mt-4 grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required placeholder="Masukan Lokasi Kantor" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="grid gap-2 pt-2">
                    <Label for="lokasi">Lokasi</Label>
                    <Textarea
                        id="lokasi"
                        type="textarea"
                        class="mt-1 block w-full"
                        v-model="form.lokasi"
                        required
                        placeholder="Masukan Lokasi Kantor"
                    ></Textarea>
                    <InputError class="mt-2" :message="form.errors.lokasi" />
                </div>
                <Button type="submit" class="mt-4 w-full" :disabled="form.processing">Create New Kantor</Button>
            </form>
        </Card>
    </AppLayout>
</template>
