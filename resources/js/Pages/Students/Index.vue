<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import debounce from "lodash.debounce";

const props = defineProps({
  students: {
    type: Object,
  },
  filters: {
    type: Object,
  }
});

const searchTerm = ref(props.filters.search || "");

// Watch for changes in the search term and update the URL query string
watch(searchTerm, debounce((value) => {
    router.visit(route("students.index", { search: value }), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
    });
}, 500));

const deleteForm = useForm({});

const deleteStudent = (id) => {
  if (confirm("Are you sure you want to delete this student?")) {
    deleteForm.delete(route("students.destroy", id), {
      preserveScroll: true,
    });
  }
};
</script>

<template>

  <Head title="Students" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Students
      </h2>
    </template>
    <div class="py-10 bg-gray-100">
      <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-xl font-semibold text-gray-900">
                Students
              </h1>
              <p class="mt-2 text-sm text-gray-700">
                A list of all the Students.
              </p>
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <Link :href="route('students.create')"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
              Add Student
              </Link>
            </div>
          </div>

          <div class="flex flex-col justify-between mt-6 sm:flex-row">
            <div class="relative col-span-3 text-sm text-gray-800">
              <div class="absolute top-0 bottom-0 left-0 flex items-center pl-2 text-gray-500 pointer-events-none">
                <MagnifyingGlass />
              </div>

              <input type="text" v-model="searchTerm" placeholder="Search students data..." id="search"
                class="block py-2 pl-10 text-gray-900 border-0 rounded-lg ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="flex flex-col mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                          ID
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                          Name
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                          Email
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Class
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Section
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Created At
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="student in students.data" :key="student.id">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                          {{ student.id }}
                        </td>
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                          {{ student.name }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ student.email }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ student.kelas.name }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ student.section.name }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{
                            student.created_at
                          }}
                        </td>

                        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                          <Link :href="route(
                            'students.edit',
                            student.id
                          )
                            " class="text-indigo-600 hover:text-indigo-900">
                          Edit
                          </Link>
                          <button @click="
                            deleteStudent(
                              student.id
                            )
                            " class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Pagination :data="students" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
