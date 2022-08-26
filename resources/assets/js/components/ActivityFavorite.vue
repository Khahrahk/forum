<template>
    <activity-layout>
        <span slot="activity">
            добавил в избранное <a class="text-black" :href="activity.favoritedModel.path"><strong>ответ </strong></a>
            {{ activity.favoritedModel.created_at }} в:
        </span>

        <div slot="heading" class="text-xl font-semibold my-4">
            <a class="text-blue font-bold mb-4" :href="activity.favoritedModel.path">"{{ activity.favoritedModel.thread.title }}"</a>

            <p class="text-2xs text-grey-darkest font-medium mb-4">
                Запостил: <a :href="activity.favoritedModel.thread.creator.username" class="text-blue">{{
                activity.favoritedModel.thread.creator.username }}</a>
            </p>
        </div>

        <div slot="body">
            <div class="text-grey-darkest leading-loose mb-4 max-h-24 overflow-hidden">
                <div class="ml-6 my-4 pl-4 border-l-2 border-grey-dark">
                    <highlight :content="activity.favoritedModel.body"/>
                </div>
            </div>

            <div class="flex items-center py-1 text-xs text-grey-darkest">
                &#8943; <a class="ml-1 text-2xs text-black" :href="activity.favoritedModel.path">больше</a>
            </div>
        </div>
    </activity-layout>
</template>

<script>
export default {
    props: {
        activity: {
            required: true
        }
    }
};
</script>
