<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';

const props = defineProps({
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
});

const addTeamProfesseurForm = useForm({
    email: '',
    role: null,
});

const updateRoleForm = useForm({
    role: null,
});

const leaveTeamForm = useForm();
const removeTeamProfesseurForm = useForm();

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingTeam = ref(false);
const teamProfesseurBeingRemoved = ref(null);

const addTeamProfesseur = () => {
    addTeamProfesseurForm.post(route('team-Professeurs.store', props.team), {
        errorBag: 'addTeamProfesseur',
        preserveScroll: true,
        onSuccess: () => addTeamProfesseurForm.reset(),
    });
};

const cancelTeamInvitation = (invitation) => {
    Inertia.delete(route('team-invitations.destroy', invitation), {
        preserveScroll: true,
    });
};

const manageRole = (teamProfesseur) => {
    managingRoleFor.value = teamProfesseur;
    updateRoleForm.role = teamProfesseur.professeurship.role;
    currentlyManagingRole.value = true;
};

const updateRole = () => {
    updateRoleForm.put(route('team-professeurs.update', [props.team, managingRoleFor.value]), {
        preserveScroll: true,
        onSuccess: () => currentlyManagingRole.value = false,
    });
};

const confirmLeavingTeam = () => {
    confirmingLeavingTeam.value = true;
};

const leaveTeam = () => {
    leaveTeamForm.delete(route('team-Professeurs.destroy', [props.team, usePage().props.value.user]));
};

const confirmTeamProfesseurRemoval = (teamProfesseur) => {
    teamProfesseurBeingRemoved.value = teamProfesseur;
};

const removeTeamProfesseur = () => {
    removeTeamProfesseurForm.delete(route('team-professeurs.destroy', [props.team, teamProfesseurBeingRemoved.value]), {
        errorBag: 'removeTeamProfesseur',
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => teamProfesseurBeingRemoved.value = null,
    });
};

const displayableRole = (role) => {
    return props.availableRoles.find(r => r.key === role).name;
};
</script>

<template>
    <div>
        <div v-if="userPermissions.canAddTeamProfesseurs">
            <JetSectionBorder />

            <!-- Add Team Professeur -->
            <JetFormSection @submitted="addTeamProfesseur">
                <template #title>
                    Add Team Professeur
                </template>

                <template #description>
                    Add a new team professeur to your team, allowing them to collaborate with you.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            Please provide the email address of the person you would like to add to this team.
                        </div>
                    </div>

                    <!-- Professeur Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <JetLabel for="email" value="Email" />
                        <JetInput
                            id="email"
                            v-model="addTeamProfesseurForm.email"
                            type="email"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="addTeamProfesseurForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div v-if="availableRoles.length > 0" class="col-span-6 lg:col-span-4">
                        <JetLabel for="roles" value="Role" />
                        <JetInputError :message="addTeamProfesseurForm.errors.role" class="mt-2" />

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            <button
                                v-for="(role, i) in availableRoles"
                                :key="role.key"
                                type="button"
                                class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200"
                                :class="{'border-t border-gray-200 rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                                @click="addTeamProfesseurForm.role = role.key"
                            >
                                <div :class="{'opacity-50': addTeamProfesseurForm.role && addTeamProfesseurForm.role != role.key}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600" :class="{'font-semibold': addTeamProfesseurForm.role == role.key}">
                                            {{ role.name }}
                                        </div>

                                        <svg
                                            v-if="addTeamProfesseurForm.role == role.key"
                                            class="ml-2 h-5 w-5 text-green-400"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 text-left">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <JetActionMessage :on="addTeamProfesseurForm.recentlySuccessful" class="mr-3">
                        Added.
                    </JetActionMessage>

                    <JetButton :class="{ 'opacity-25': addTeamProfesseurForm.processing }" :disabled="addTeamProfesseurForm.processing">
                        Add
                    </JetButton>
                </template>
            </JetFormSection>
        </div>

        <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamProfesseurs">
            <JetSectionBorder />

            <!-- Team Professeur Invitations -->
            <JetActionSection class="mt-10 sm:mt-0">
                <template #title>
                    Pending Team Invitations
                </template>

                <template #description>
                    These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.
                </template>

                <!-- Pending Team Professeur Invitation List -->
                <template #content>
                    <div class="space-y-6">
                        <div v-for="invitation in team.team_invitations" :key="invitation.id" class="flex items-center justify-between">
                            <div class="text-gray-600">
                                {{ invitation.email }}
                            </div>

                            <div class="flex items-center">
                                <!-- Cancel Team Invitation -->
                                <button
                                    v-if="userPermissions.canRemoveTeamProfesseurs"
                                    class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                    @click="cancelTeamInvitation(invitation)"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </JetActionSection>
        </div>

        <div v-if="team.users.length > 0">
            <JetSectionBorder />

            <!-- Manage Team Professeurs -->
            <JetActionSection class="mt-10 sm:mt-0">
                <template #title>
                    Team Professeurs
                </template>

                <template #description>
                    All of the people that are part of this team.
                </template>

                <!-- Team Professeur List -->
                <template #content>
                    <div class="space-y-6">
                        <div v-for="user in team.users" :key="user.id" class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" :src="user.profile_photo_url" :alt="user.name">
                                <div class="ml-4">
                                    {{ user.name }}
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Professeur Role -->
                                <button
                                    v-if="userPermissions.canAddTeamProfesseurs && availableRoles.length"
                                    class="ml-2 text-sm text-gray-400 underline"
                                    @click="manageRole(user)"
                                >
                                    {{ displayableRole(user.professeurship.role) }}
                                </button>

                                <div v-else-if="availableRoles.length" class="ml-2 text-sm text-gray-400">
                                    {{ displayableRole(user.professeurship.role) }}
                                </div>

                                <!-- Leave Team -->
                                <button
                                    v-if="$page.props.user.id === user.id"
                                    class="cursor-pointer ml-6 text-sm text-red-500"
                                    @click="confirmLeavingTeam"
                                >
                                    Leave
                                </button>

                                <!-- Remove Team Professeur -->
                                <button
                                    v-if="userPermissions.canRemoveTeamProfesseurs"
                                    class="cursor-pointer ml-6 text-sm text-red-500"
                                    @click="confirmTeamProfesseurRemoval(user)"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </JetActionSection>
        </div>

        <!-- Role Management Modal -->
        <JetDialogModal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
            <template #title>
                Manage Role
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        <button
                            v-for="(role, i) in availableRoles"
                            :key="role.key"
                            type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200"
                            :class="{'border-t border-gray-200 rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
                            @click="updateRoleForm.role = role.key"
                        >
                            <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role !== role.key}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600" :class="{'font-semibold': updateRoleForm.role === role.key}">
                                        {{ role.name }}
                                    </div>

                                    <svg
                                        v-if="updateRoleForm.role === role.key"
                                        class="ml-2 h-5 w-5 text-green-400"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600">
                                    {{ role.description }}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </template>

            <template #footer>
                <JetSecondaryButton @click="currentlyManagingRole = false">
                    Cancel
                </JetSecondaryButton>

                <JetButton
                    class="ml-3"
                    :class="{ 'opacity-25': updateRoleForm.processing }"
                    :disabled="updateRoleForm.processing"
                    @click="updateRole"
                >
                    Save
                </JetButton>
            </template>
        </JetDialogModal>

        <!-- Leave Team Confirmation Modal -->
        <JetConfirmationModal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
            <template #title>
                Leave Team
            </template>

            <template #content>
                Are you sure you would like to leave this team?
            </template>

            <template #footer>
                <JetSecondaryButton @click="confirmingLeavingTeam = false">
                    Cancel
                </JetSecondaryButton>

                <JetDangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': leaveTeamForm.processing }"
                    :disabled="leaveTeamForm.processing"
                    @click="leaveTeam"
                >
                    Leave
                </JetDangerButton>
            </template>
        </JetConfirmationModal>

        <!-- Remove Team Professeur Confirmation Modal -->
        <JetConfirmationModal :show="teamProfesseurBeingRemoved" @close="teamProfesseurBeingRemoved = null">
            <template #title>
                Remove Team Professeur
            </template>

            <template #content>
                Are you sure you would like to remove this person from the team?
            </template>

            <template #footer>
                <JetSecondaryButton @click="teamProfesseurBeingRemoved = null">
                    Cancel
                </JetSecondaryButton>

                <JetDangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': removeTeamProfesseurForm.processing }"
                    :disabled="removeTeamProfesseurForm.processing"
                    @click="removeTeamv"
                >
                    Remove
                </JetDangerButton>
            </template>
        </JetConfirmationModal>
    </div>
</template>
