import {
  computed, isRef, reactive, toRefs, watch,
} from 'vue';
import type { ComputedRef } from 'vue';
import type fb from 'firebase';
import type { CollectionRef, DocRef } from 'app/common/firestore';
import type { Model } from 'app/common/schema';

type MaybeReactiveDocRef<T> = DocRef.base<T> | ComputedRef<DocRef.base<T>>;

type MaybeReactiveCollectionRef<T> = CollectionRef.base<T> | ComputedRef<CollectionRef.base<T>>
  | ComputedRef<fb.firestore.Query<Model<T>>> | fb.firestore.Query<Model<T>>;

const reactivyDocRef = <T>(docRef: MaybeReactiveDocRef<T>) => computed(
  () => (isRef(docRef) ? docRef.value : docRef),
);

const reactivyCollectionRef = <T>(docRef: MaybeReactiveCollectionRef<T>) => computed(
  () => (isRef(docRef) ? docRef.value : docRef),
);

export const useDoc = <T>(docRef: MaybeReactiveDocRef<T>) => {
  const reactiveDocRef = reactivyDocRef(docRef);
  const state = reactive({
    data: null as (Model<T> | null),
    error: null as (fb.FirebaseError | null),
    isLoading: true,
  });
  const update = () => {
    state.isLoading = true;
    reactiveDocRef.value.get()
      .then((doc) => {
        state.data = (doc.data() ?? null) as typeof state.data;
      })
      .catch((err: fb.FirebaseError) => {
        state.error = err;
      })
      .finally(() => {
        state.isLoading = false;
      });
  };

  watch(reactiveDocRef, () => update(), { immediate: true });

  return { ...toRefs(state), update };
};

export const useCollection = <T>(collectionRef: MaybeReactiveCollectionRef<T>) => {
  const reactiveCollectionRef = reactivyCollectionRef(collectionRef);
  const state = reactive<{
    data: Model<T>[];
    error: fb.FirebaseError | null,
    isLoading: boolean;
  }>({
    data: [],
    error: null,
    isLoading: true,
  });
  const update = () => {
    state.isLoading = true;

    reactiveCollectionRef.value.get()
      .then((snapshot) => {
        state.data = snapshot.docs.map((el) => el.data()) as typeof state.data;
      })
      .catch((err: fb.FirebaseError) => {
        state.error = err;
      })
      .finally(() => {
        state.isLoading = false;
      });
  };

  watch(reactiveCollectionRef, () => update(), { immediate: true });

  return { ...toRefs(state), update };
};
