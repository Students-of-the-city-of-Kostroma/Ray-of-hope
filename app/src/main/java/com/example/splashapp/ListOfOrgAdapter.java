package com.example.splashapp;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class ListOfOrgAdapter extends RecyclerView.Adapter<ListOfOrgAdapter.ViewHolder> {


    private List<M_Organization> Org;
    private List<M_Organization> itemsCopy=new ArrayList<M_Organization>();
    private Context context;
    private ItemClickListener mClickListener;

    public ListOfOrgAdapter(Context context,List<M_Organization> Org)
    {
        this.Org=Org;
        this.context=context;
        itemsCopy.addAll(Org);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.org_in_list,parent,false);
        return  new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(ViewHolder  holder, int position) {
        M_Organization or=Org.get(position);
        holder.id=or.getId();
        holder.name.setText(or.getName());
        holder.about.setText(or.getAbout());
        Picasso.get().load(R.mipmap.about_logo).into(holder.imageView);
    }

    @Override
    public int getItemCount() {
        return Org.size();
    }

    public void filter(String text, String city, String activ) {
        Org.clear();
        if(text.isEmpty()){
            Org.addAll(itemsCopy);
        } else{
            text = text.toLowerCase();
            for(M_Organization item: itemsCopy){
                if(item.getName().toLowerCase().contains(text)& item.getCity().contains(city)&item.getTypeActivity().contains(activ)){
                    Org.add(item);
                }
            }
        }
        notifyDataSetChanged();
    }

    public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public String id;
        public TextView about;
        public ImageView imageView;
        public TextView name;



        public ViewHolder (View itemView)
        {
            super(itemView);
            imageView =(ImageView) itemView.findViewById(R.id.imageView12);
            name=(TextView) itemView.findViewById(R.id.textView31);
            about=(TextView) itemView.findViewById(R.id.textView32);

            itemView.setOnClickListener(this);
        }
        @Override
        public void onClick(View view) {
            if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
        }
    }

    public M_Organization getOrg(int id) {
        return Org.get(id);
    }

    public void setClickListener(ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

    public interface ItemClickListener {
        void onItemClick(View view, int position);
    }
}
