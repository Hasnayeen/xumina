import Action from "../action";

export default function ActionContainer ({ actions }: { actions: [] }) {
  return (
    <>
      {actions.map(({ id, data }) => (
        <div key={id} className="hidden items-center gap-2 md:ml-auto md:flex">
          <Action id={id} data={data} type="Action" />
        </div>
      ))}
    </>
  );
}

