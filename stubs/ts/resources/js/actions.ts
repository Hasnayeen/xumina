import * as packageActions from "@/xumina/actions";

export type ActionFunction = (data: any) => void;

interface Actions {
  [key: string]: ActionFunction;
}

export const actions: Actions = {
  ...packageActions,
  // add your actions here
  /*
  customAction: (data: any) => {
    console.log('Custom action executed with data:', data);
  };
  */
};
