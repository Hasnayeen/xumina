import Action from "../action";

export default function ActionContainer({ actions }: { actions: [] }) {
  return (
    <>
      {actions.map(({ id, data, type }) => (
        <div key={id} className="items-center gap-2 md:ml-auto md:flex">
          <Action id={id} data={data} type={type} />
        </div>
      ))}
    </>
  );
}
